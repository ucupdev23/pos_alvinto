<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Transaksi_model');
        $this->load->model('Gaji_kasir_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $today = date('Y-m-d');
        $tahun = date('Y');
        $bulan = date('m');

        $rekap_hari = $this->Transaksi_model->get_rekap_hari($today);
        $rekap_bulan = $this->Transaksi_model->get_rekap_bulan($tahun, $bulan);

        // Hitung Keuntungan Hari Ini
        $gaji_karyawan_hari = $this->Transaksi_model->get_total_gaji_karyawan_by_date($today);
        $gaji_kasir_hari = $this->Gaji_kasir_model->get_total_gaji_kasir_by_date($today);
        $profit_hari = $rekap_hari['total_omzet'] - ($gaji_karyawan_hari + $gaji_kasir_hari);
        $rekap_hari['profit'] = $profit_hari;

        // Hitung Keuntungan Bulan Ini
        $gaji_karyawan_bulan = $this->Transaksi_model->get_total_gaji_karyawan_by_date(null, $bulan, $tahun);
        $gaji_kasir_bulan = $this->Gaji_kasir_model->get_total_gaji_kasir_by_date(null, $bulan, $tahun);
        $profit_bulan = $rekap_bulan['total_omzet'] - ($gaji_karyawan_bulan + $gaji_kasir_bulan);
        $rekap_bulan['profit'] = $profit_bulan;

        $top_hari = $this->Transaksi_model->get_top_karyawan_hari($today, 3);
        $top_bulan = $this->Transaksi_model->get_top_karyawan_bulan($tahun, $bulan, 3);

        // Pass model Gaji_kasir ke get_rekap_mingguan karena butuh hitung profit
        $chart_mingguan = $this->Transaksi_model->get_rekap_mingguan($this->Gaji_kasir_model);

        // 5 Transaksi terakhir
        $recent_transaksi = $this->Transaksi_model->get_laporan_transaksi(null, null, null, null, null, 5, 0);
        // Note: get_laporan_transaksi sort by date ASC by default in model, we might need DESC for recent.
        // Let's check model again or sort here. 
        // Logic di model order by tanggal ASC, id ASC. 
        // For recent, we need DESC. I should probably add order param to model or just sort array here.
        // Or better, add 'recent' param to get_laporan_transaksi or make a new small query here for simplicity/performance.

        // Revisi: Buat query simple aja buat recent daripada ubah logic besar di get_laporan
        $this->db->select('transaksi.*, karyawan.nama as nama_karyawan, jenis_pangkas.nama as jenis_pangkas');
        $this->db->from('transaksi');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $recent_transaksi = $this->db->get()->result();

        $data = [
            'title' => 'Dashboard Admin',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Ringkasan Usaha',
            'page' => 'admin/dashboard',
            'bottom_nav' => $this->admin_bottom_nav('home'),
            'page_data' => [
                'today' => $today,
                'rekap_hari' => $rekap_hari,
                'rekap_bulan' => $rekap_bulan,
                'top_hari' => $top_hari,
                'top_bulan' => $top_bulan,
                'chart_mingguan' => $chart_mingguan,
                'recent_transaksi' => $recent_transaksi
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function reset_data()
    {
        // Hanya owner/admin yang bisa akses ini
        $this->Transaksi_model->truncate_all_transactions();
        
        $this->session->set_flashdata('success', 'Semua data transaksi dan histori berhasil dikosongkan (Reset Trial).');
        redirect('admin/dashboard');
    }
}

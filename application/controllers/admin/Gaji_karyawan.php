<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_karyawan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Karyawan_model');
        $this->load->model('Transaksi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $karyawan_id = $this->input->get('karyawan_id');
        $tanggal = $this->input->get('tanggal') ?: date('Y-m-d');

        $slip = null;
        $detail = [];

        if ($karyawan_id && $tanggal) {
            $slip = $this->Transaksi_model->get_slip_karyawan($karyawan_id, $tanggal);
            $detail = $this->Transaksi_model->get_transaksi_karyawan_harian_grouped($karyawan_id, $tanggal);
        }

        $data = [
            'title' => 'Slip Gaji Kapster',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Slip Gaji Kapster',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page' => 'admin/gaji_karyawan/index',
            'page_data' => [
                'karyawan' => $this->Karyawan_model->get_all_active(),
                'karyawan_id' => $karyawan_id,
                'tanggal' => $tanggal,
                'slip' => $slip,
                'detail' => $detail
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function kirim_wa()
    {
        $karyawan_id = $this->input->post('karyawan_id');
        $tanggal = $this->input->post('tanggal');

        if (!$karyawan_id || !$tanggal) {
            $this->session->set_flashdata('error', 'Data tidak lengkap.');
            redirect('admin/gaji_karyawan');
        }

        // 1. Ambil data slip & karyawan
        $slip = $this->Transaksi_model->get_slip_karyawan($karyawan_id, $tanggal);
        $karyawan = $this->Karyawan_model->get_by_id($karyawan_id);

        if (!$slip || !$karyawan) {
            $this->session->set_flashdata('error', 'Data gaji tidak ditemukan.');
            redirect('admin/gaji_karyawan?karyawan_id=' . $karyawan_id . '&tanggal=' . $tanggal);
        }

        if (empty($karyawan->no_hp)) {
            $this->session->set_flashdata('error', 'Nomor HP karyawan belum diatur.');
            redirect('admin/gaji_karyawan?karyawan_id=' . $karyawan_id . '&tanggal=' . $tanggal);
        }

        // 2. Simpan history gaji (jika belum ada)
        $this->Transaksi_model->save_gaji_if_not_exists($karyawan_id, $tanggal);

        // 3. Format Pesan WhatsApp
        $tgl_indo = date('d/m/Y', strtotime($tanggal));
        $omzet = number_format($slip['total_omzet'], 0, ',', '.');
        $upah = number_format($slip['upah'], 0, ',', '.');
        $makan = number_format($slip['uang_makan'], 0, ',', '.');
        $total = number_format($slip['total_gaji'], 0, ',', '.');

        // Ambil detail transaksi
        $details = $this->Transaksi_model->get_transaksi_karyawan_harian_grouped($karyawan_id, $tanggal);

        $message = "*SLIP GAJI HARIAN*\n";
        $message .= "Alvinto Haircut\n\n";
        $message .= "Halo *$karyawan->nama*,\n";
        $message .= "Berikut adalah rincian gaji Anda untuk tanggal *$tgl_indo*:\n\n";

        // Rincian Potongan
        if (!empty($details)) {
            $message .= "*Detail Potongan:*\n";
            foreach ($details as $d) {
                $subtotal = number_format($d->total_harga, 0, ',', '.');
                $message .= "- $d->jenis_pangkas ($d->metode_bayar): $d->qty x = Rp $subtotal\n";
            }
            $message .= "\n";
        }

        $message .= "Total Omzet: Rp $omzet\n";
        $message .= "Upah (50%): Rp $upah\n";
        $message .= "Uang Makan: Rp $makan\n";
        $message .= "----------------------------------\n";
        $message .= "*TOTAL TERIMA: Rp $total*\n\n";
        $message .= "Terima kasih atas kerja kerasnya hari ini, semoga berkah..!💪";

        // 3. Kirim via Helper
        $res = send_wa($karyawan->no_hp, $message);

        if ($res['status']) {
            $this->session->set_flashdata('success', 'Slip gaji berhasil dikirim ke WA karyawan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengirim WA: ' . $res['message']);
        }

        redirect('admin/gaji_karyawan?karyawan_id=' . $karyawan_id . '&tanggal=' . $tanggal);
    }
}

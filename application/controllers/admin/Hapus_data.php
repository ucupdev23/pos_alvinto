<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hapus_data extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Transaksi_model');
        $this->load->model('User_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Metode_pembayaran_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');
        $kasir_id = $this->input->get('kasir_id');
        $karyawan_id = $this->input->get('karyawan_id');
        $metode_id = $this->input->get('metode_id');

        // Pagination
        $this->load->library('pagination');

        $per_page = 15; // Show slightly more for easier batch delete
        $page = (int)$this->input->get('page');
        $offset = $page ? ($page - 1) * $per_page : 0;

        $total_rows = $this->Transaksi_model->count_laporan_transaksi(
            $tanggal_mulai,
            $tanggal_selesai,
            $kasir_id,
            $karyawan_id,
            $metode_id
        );

        $laporan = $this->Transaksi_model->get_laporan_transaksi(
            $tanggal_mulai,
            $tanggal_selesai,
            $kasir_id,
            $karyawan_id,
            $metode_id,
            $per_page,
            $offset
        );

        // Config pagination
        $params = $_GET;
        unset($params['page']);
        $query_string = http_build_query($params);

        $config['base_url'] = site_url('admin/hapus_data') . ($query_string ? '?' . $query_string : '');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $config['use_page_numbers'] = true;

        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm justify-content-center mt-2">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data = [
            'title' => 'Pengaturan Hapus Data',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Pengaturan Hapus Data',
            'page' => 'admin/hapus_data',
            'bottom_nav' => $this->admin_bottom_nav('home'),
            'page_data' => [
                'laporan' => $laporan,
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $total_rows,
                'offset' => $offset,
                'per_page' => $per_page,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'kasir_id' => $kasir_id,
                'karyawan_id' => $karyawan_id,
                'metode_id' => $metode_id,
                'kasir_list' => $this->User_model->get_all_kasir(),
                'karyawan_list' => $this->Karyawan_model->get_all_active(),
                'metode_list' => $this->Metode_pembayaran_model->get_all_active(),
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function hapus_single($id)
    {
        if ($this->Transaksi_model->delete_transaksi($id)) {
            $this->session->set_flashdata('success', 'Transaksi berhasil dihapus dan gaji karyawan disinkronkan.');
        } else {
            $this->session->set_flashdata('error', 'Transaksi tidak ditemukan atau gagal dihapus.');
        }
        
        // Preserve current query params when redirecting back
        $query = $this->input->server('QUERY_STRING');
        redirect('admin/hapus_data' . ($query ? '?' . $query : ''));
    }

    public function hapus_selected()
    {
        $ids = $this->input->post('ids');
        if (empty($ids)) {
            $this->session->set_flashdata('error', 'Tidak ada data transaksi yang dipilih.');
            redirect('admin/hapus_data');
        }

        if ($this->Transaksi_model->delete_transaksi_batch($ids)) {
            $this->session->set_flashdata('success', count($ids) . ' transaksi berhasil dihapus dan gaji karyawan disinkronkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus transaksi terpilih.');
        }

        // Preserve current query params when redirecting back
        $query = $this->input->server('QUERY_STRING');
        redirect('admin/hapus_data' . ($query ? '?' . $query : ''));
    }

    public function hapus_by_filter()
    {
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        $kasir_id = $this->input->post('kasir_id');
        $karyawan_id = $this->input->post('karyawan_id');
        $metode_id = $this->input->post('metode_id');

        if (!$tanggal_mulai && !$tanggal_selesai && !$kasir_id && !$karyawan_id && !$metode_id) {
            $this->session->set_flashdata('error', 'Harap tentukan setidaknya satu kriteria filter untuk menghapus data berdasarkan filter.');
            redirect('admin/hapus_data');
        }

        if ($this->Transaksi_model->delete_transaksi_by_filter($tanggal_mulai, $tanggal_selesai, $kasir_id, $karyawan_id, $metode_id)) {
            $this->session->set_flashdata('success', 'Seluruh transaksi sesuai kriteria filter berhasil dihapus dan gaji karyawan disinkronkan.');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada transaksi yang cocok dengan kriteria filter tersebut untuk dihapus.');
        }

        redirect('admin/hapus_data');
    }

    public function reset_all()
    {
        $this->Transaksi_model->truncate_all_transactions();
        $this->session->set_flashdata('success', 'Semua data transaksi dan histori berhasil dikosongkan (Reset Trial).');
        redirect('admin/dashboard');
    }
}

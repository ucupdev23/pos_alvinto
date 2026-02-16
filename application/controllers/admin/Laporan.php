<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Transaksi_model');
        $this->load->model('User_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Metode_pembayaran_model');
    }

    public function index()
{
    $tanggal_mulai   = $this->input->get('tanggal_mulai') ?: date('Y-m-01');
    $tanggal_selesai = $this->input->get('tanggal_selesai') ?: date('Y-m-d');
    $kasir_id        = $this->input->get('kasir_id');
    $karyawan_id     = $this->input->get('karyawan_id');
    $metode_id       = $this->input->get('metode_id');

    // 🔥 PAGINATION DULU
    $this->load->library('pagination');

    $per_page = 10;
    $page     = (int) $this->input->get('page');
    $offset   = $page ? ($page - 1) * $per_page : 0;

    $total_rows = $this->Transaksi_model->count_laporan_transaksi(
        $tanggal_mulai,
        $tanggal_selesai,
        $kasir_id,
        $karyawan_id,
        $metode_id
    );

    // 🔥 BARU AMBIL DATA
    $laporan = $this->Transaksi_model->get_laporan_transaksi(
        $tanggal_mulai,
        $tanggal_selesai,
        $kasir_id,
        $karyawan_id,
        $metode_id,
        $per_page,
        $offset
    );

    $rekap = $this->Transaksi_model->get_rekap_omzet($tanggal_mulai, $tanggal_selesai);

    // config pagination
    $config['base_url']            = site_url('admin/laporan?' . http_build_query($_GET));
    $config['total_rows']          = $total_rows;
    $config['per_page']            = $per_page;
    $config['page_query_string']   = true;
    $config['query_string_segment']= 'page';
    $config['reuse_query_string']  = true;

    $config['full_tag_open']   = '<nav><ul class="pagination pagination-sm justify-content-center mt-2">';
    $config['full_tag_close']  = '</ul></nav>';
    $config['num_tag_open']    = '<li class="page-item">';
    $config['num_tag_close']   = '</li>';
    $config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']   = '</span></li>';
    $config['attributes']      = ['class' => 'page-link'];

    $this->pagination->initialize($config);

    $data = [
        'title'     => 'Laporan Transaksi',
        'page'      => 'admin/laporan_transaksi',
        'page_data' => [
            'laporan'     => $laporan,
            'rekap'       => $rekap,
            'pagination'  => $this->pagination->create_links(),
            'total_rows'  => $total_rows,
            'offset'      => $offset,
            'per_page'    => $per_page,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'kasir_id'        => $kasir_id,
            'karyawan_id'     => $karyawan_id,
            'metode_id'       => $metode_id,
            'kasir_list'      => $this->User_model->get_all_kasir(),
            'karyawan_list'   => $this->Karyawan_model->get_all_active(),
            'metode_list'     => $this->Metode_pembayaran_model->get_all_active(),
        ],
        'bottom_nav'   => $this->admin_bottom_nav('laporan')
    ];

    $this->load->view('layouts/mobile', $data);
}

}

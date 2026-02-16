<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_kasir extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Gaji_kasir_model');
        $this->load->model('User_model');
        $this->load->model('Transaksi_model'); // <--- tambahkan ini
    }

    public function index()
    {
        // Filter list gaji kasir (periode)
        $tanggal_mulai   = $this->input->get('tanggal_mulai') ?: date('Y-m-01');
        $tanggal_selesai = $this->input->get('tanggal_selesai') ?: date('Y-m-d');
        $kasir_id_filter = $this->input->get('kasir_id');

        $gaji_list = $this->Gaji_kasir_model->get_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id_filter);

        // Kalkulator saldo harian kasir
        $kasir_hari_id = $this->input->get('kasir_hari_id');
        $tanggal_hari  = $this->input->get('tanggal_hari') ?: date('Y-m-d');
        $rekap_harian  = null;

        if ($kasir_hari_id && $tanggal_hari) {
            $rekap_harian = $this->Transaksi_model->get_rekap_kasir_harian($kasir_hari_id, $tanggal_hari);
        }

        $data = [
            'title'        => 'Gaji Kasir',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Input & Laporan Gaji Kasir',
            'page'         => 'admin/gaji_kasir_index',
            'page_data'    => [
                'gaji_list'        => $gaji_list,
                'tanggal_mulai'    => $tanggal_mulai,
                'tanggal_selesai'  => $tanggal_selesai,
                'kasir_id_filter'  => $kasir_id_filter,
                'kasir_list'       => $this->User_model->get_all_kasir(),
                // data buat kalkulator saldo
                'kasir_hari_id'    => $kasir_hari_id,
                'tanggal_hari'     => $tanggal_hari,
                'rekap_harian'     => $rekap_harian
            ],
            'bottom_nav' => $this->admin_bottom_nav('more')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $tanggal = $this->input->post('tanggal', TRUE);
        $kasir_id= $this->input->post('kasir_id', TRUE);
        $jumlah  = $this->input->post('jumlah', TRUE);
        $catatan = $this->input->post('catatan', TRUE);

        if (!$tanggal || !$kasir_id || !$jumlah) {
            $this->session->set_flashdata('error', 'Tanggal, kasir, dan jumlah wajib diisi.');
            redirect('admin/gaji_kasir');
        }

        $data = [
            'tanggal' => $tanggal,
            'kasir_id'=> $kasir_id,
            'jumlah'  => $jumlah,
            'catatan' => $catatan
        ];

        if ($this->Gaji_kasir_model->insert($data)) {
            $this->session->set_flashdata('success', 'Gaji kasir berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan gaji kasir.');
        }

        redirect('admin/gaji_kasir');
    }
}

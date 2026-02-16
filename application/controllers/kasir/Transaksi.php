<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('kasir');
        $this->load->model('Karyawan_model');
        $this->load->model('Jenis_pangkas_model');
        $this->load->model('Metode_pembayaran_model');
        $this->load->model('Transaksi_model');
    }

    public function index()
    {
        $data = [
            'title'        => 'Input Transaksi',
            'app_title'    => 'Kasir Alvinto',
            'app_subtitle' => 'Input Transaksi',
            'bottom_nav'   => $this->kasir_bottom_nav('transaksi'),
            'page'         => 'kasir/transaksi_form',
            'page_data'    => [
                'karyawan'       => $this->Karyawan_model->get_all_active(),
                'jenis_pangkas'  => $this->Jenis_pangkas_model->get_all_active(),
                'metode_bayar'   => $this->Metode_pembayaran_model->get_all_active(),
                'tanggal_hari_ini' => date('Y-m-d')
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $karyawan_id          = $this->input->post('karyawan_id', TRUE);
        $jenis_pangkas_id     = $this->input->post('jenis_pangkas_id', TRUE);
        $metode_pembayaran_id = $this->input->post('metode_pembayaran_id', TRUE);
        $kasir_id             = $this->session->userdata('user_id');

        if (!$karyawan_id || !$jenis_pangkas_id || !$metode_pembayaran_id) {
            $this->session->set_flashdata('error', 'Harap lengkapi semua kolom.');
            redirect('kasir/transaksi');
        }

        $insert = $this->Transaksi_model->insert_transaksi(
            $kasir_id,
            $karyawan_id,
            $jenis_pangkas_id,
            $metode_pembayaran_id
        );

        if ($insert) {
            $this->session->set_flashdata('success', 'Transaksi berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi.');
        }

        redirect('kasir/transaksi');
    }
}

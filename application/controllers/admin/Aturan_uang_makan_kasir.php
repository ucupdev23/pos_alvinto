<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aturan_uang_makan_kasir extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Aturan_uang_makan_kasir_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title' => 'Aturan Uang Makan Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Aturan Uang Makan Kasir',
            'page' => 'admin/aturan_uang_makan_kasir/index',
            'page_data' => [
                'list' => $this->Aturan_uang_makan_kasir_model->get_all()
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($tipe_kasir)
    {
        $aturan = $this->Aturan_uang_makan_kasir_model->get_by_tipe($tipe_kasir);
        if (!$aturan) {
            show_404();
        }

        $data = [
            'title' => 'Edit Aturan Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Edit Uang Makan ' . ucfirst($tipe_kasir),
            'page' => 'admin/aturan_uang_makan_kasir/form',
            'page_data' => [
                'aturan' => $aturan
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $tipe_kasir = $this->input->post('tipe_kasir');
        $uang_makan = (int)$this->input->post('uang_makan');

        $data = [
            'uang_makan' => $uang_makan
        ];

        $this->Aturan_uang_makan_kasir_model->update($tipe_kasir, $data);
        $this->session->set_flashdata('success', 'Aturan berhasil diupdate.');

        redirect('admin/aturan_uang_makan_kasir');
    }
}

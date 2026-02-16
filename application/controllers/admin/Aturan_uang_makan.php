<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan_uang_makan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Aturan_uang_makan_model');
    }

    public function index()
    {
        $data = [
            'title'        => 'Aturan Uang Makan',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Aturan Uang Makan',
            'page'         => 'admin/aturan_uang_makan/index',
            'page_data'    => [
                'list' => $this->Aturan_uang_makan_model->get_all()
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function tambah()
    {
        $data = [
            'title'        => 'Tambah Aturan',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Tambah Aturan',
            'page'         => 'admin/aturan_uang_makan/form',
            'page_data'    => [
                'mode'   => 'tambah',
                'aturan' => null
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($id)
    {
        $aturan = $this->Aturan_uang_makan_model->get_by_id($id);
        if (!$aturan || $aturan->status != 1) {
            show_404();
        }

        $data = [
            'title'        => 'Edit Aturan',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Edit Aturan',
            'page'         => 'admin/aturan_uang_makan/form',
            'page_data'    => [
                'mode'   => 'edit',
                'aturan' => $aturan
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $mode = $this->input->post('mode');
        $id   = $this->input->post('id');

        $data = [
            'upah_min'   => (int) $this->input->post('upah_min'),
            'upah_max'   => $this->input->post('upah_max') !== '' ? (int)$this->input->post('upah_max') : null,
            'uang_makan' => (int) $this->input->post('uang_makan')
        ];

        if ($mode == 'tambah') {
            $this->Aturan_uang_makan_model->create($data);
            $this->session->set_flashdata('success', 'Aturan berhasil ditambahkan.');
        } else {
            $this->Aturan_uang_makan_model->update($id, $data);
            $this->session->set_flashdata('success', 'Aturan berhasil diupdate.');
        }

        redirect('admin/aturan_uang_makan');
    }

    public function hapus($id)
    {
        $aturan = $this->Aturan_uang_makan_model->get_by_id($id);
        if (!$aturan) {
            show_404();
        }

        $this->Aturan_uang_makan_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Aturan berhasil dinonaktifkan.');
        redirect('admin/aturan_uang_makan');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pangkas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Jenis_pangkas_model');
    }

    public function index()
    {
        $data = [
            'title'        => 'Jenis Pangkas',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Jenis Pangkas',
            'page'         => 'admin/jenis_pangkas/index',
            'bottom_nav'   => $this->admin_bottom_nav('master'),
            'page_data'    => [
                'list' => $this->Jenis_pangkas_model->get_all_active()
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function tambah()
    {
        $data = [
            'title'        => 'Tambah Jenis Pangkas',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Tambah Jenis Pangkas',
            'page'         => 'admin/jenis_pangkas/form',
            'bottom_nav'   => $this->admin_bottom_nav('master'),
            'page_data'    => [
                'mode'  => 'tambah',
                'jenis' => null
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($id)
    {
        $jenis = $this->Jenis_pangkas_model->get_by_id($id);
        if (!$jenis) {
            show_404();
        }

        $data = [
            'title'        => 'Edit Jenis Pangkas',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Edit Jenis Pangkas',
            'page'         => 'admin/jenis_pangkas/form',
            'bottom_nav'   => $this->admin_bottom_nav('master'),
            'page_data'    => [
                'mode'  => 'edit',
                'jenis' => $jenis
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $mode = $this->input->post('mode');
        $id   = $this->input->post('id');

        $data = [
            'nama'   => $this->input->post('nama', TRUE),
            'harga'  => (int) $this->input->post('harga', TRUE),
            'keterangan' => $this->input->post('keterangan', TRUE),
            'status' => 1
        ];

        if ($mode == 'tambah') {
            if ($this->Jenis_pangkas_model->insert($data)) {
                $this->session->set_flashdata('success', 'Jenis pangkas berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan jenis pangkas.');
            }
        } else {
            if ($this->Jenis_pangkas_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Jenis pangkas berhasil diupdate.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate jenis pangkas.');
            }
        }

        redirect('admin/jenis_pangkas');
    }

    public function hapus($id)
    {
        $jenis = $this->Jenis_pangkas_model->get_by_id($id);
        if (!$jenis) {
            show_404();
        }

        $this->Jenis_pangkas_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Jenis pangkas berhasil di-nonaktifkan.');
        redirect('admin/jenis_pangkas');
    }
}

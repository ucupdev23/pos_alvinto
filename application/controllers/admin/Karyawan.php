<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Karyawan_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Karyawan',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Karyawan',
            'page' => 'admin/karyawan/index',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'list' => $this->Karyawan_model->get_all_active()
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Tambah Karyawan',
            'page' => 'admin/karyawan/form',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'mode' => 'tambah',
                'karyawan' => null
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($id)
    {
        $karyawan = $this->Karyawan_model->get_by_id($id);
        if (!$karyawan) {
            show_404();
        }

        $data = [
            'title' => 'Edit Karyawan',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Edit Karyawan',
            'page' => 'admin/karyawan/form',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'mode' => 'edit',
                'karyawan' => $karyawan
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $mode = $this->input->post('mode');
        $id = $this->input->post('id');

        $data = [
            'nama' => $this->input->post('nama', TRUE),
            'no_hp' => $this->input->post('no_hp', TRUE),
            'status' => 1
        ];

        if ($mode == 'tambah') {
            if ($this->Karyawan_model->insert($data)) {
                $this->session->set_flashdata('success', 'Karyawan berhasil ditambahkan.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal menambahkan karyawan.');
            }
        }
        else {
            if ($this->Karyawan_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Karyawan berhasil diupdate.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal mengupdate karyawan.');
            }
        }

        redirect('admin/karyawan');
    }

    public function hapus($id)
    {
        $karyawan = $this->Karyawan_model->get_by_id($id);
        if (!$karyawan) {
            show_404();
        }

        $this->Karyawan_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Karyawan berhasil di-nonaktifkan.');
        redirect('admin/karyawan');
    }
}

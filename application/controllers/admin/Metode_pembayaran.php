<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode_pembayaran extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Metode_pembayaran_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title' => 'Metode Pembayaran',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Metode Pembayaran',
            'page' => 'admin/metode_pembayaran/index',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'list' => $this->Metode_pembayaran_model->get_all_active()
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Metode Pembayaran',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Tambah Metode Pembayaran',
            'page' => 'admin/metode_pembayaran/form',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'mode' => 'tambah',
                'metode' => null
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($id)
    {
        $metode = $this->Metode_pembayaran_model->get_by_id($id);
        if (!$metode) {
            show_404();
        }

        $data = [
            'title' => 'Edit Metode Pembayaran',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Edit Metode Pembayaran',
            'page' => 'admin/metode_pembayaran/form',
            'bottom_nav' => $this->admin_bottom_nav('master'),
            'page_data' => [
                'mode' => 'edit',
                'metode' => $metode
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
            'keterangan' => $this->input->post('keterangan', TRUE),
            'status' => 1
        ];

        if ($mode == 'tambah') {
            if ($this->Metode_pembayaran_model->insert($data)) {
                $this->session->set_flashdata('success', 'Metode pembayaran berhasil ditambahkan.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal menambahkan metode pembayaran.');
            }
        }
        else {
            if ($this->Metode_pembayaran_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Metode pembayaran berhasil diupdate.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal mengupdate metode pembayaran.');
            }
        }

        redirect('admin/metode_pembayaran');
    }

    public function hapus($id)
    {
        $metode = $this->Metode_pembayaran_model->get_by_id($id);
        if (!$metode) {
            show_404();
        }

        $this->Metode_pembayaran_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Metode pembayaran berhasil di-nonaktifkan.');
        redirect('admin/metode_pembayaran');
    }
}

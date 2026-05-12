<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('User_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Kelola Kasir',
            'page' => 'admin/kasir/index',
            'page_data' => [
                'kasir_list' => $this->User_model->get_all_kasir()
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')

        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Tambah Kasir',
            'page' => 'admin/kasir/form',
            'page_data' => [
                'mode' => 'tambah',
                'kasir' => null
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function edit($id)
    {
        $kasir = $this->User_model->get_by_id($id);
        if (!$kasir || $kasir->role != 'kasir') {
            show_404();
        }

        $data = [
            'title' => 'Edit Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Edit Kasir',
            'page' => 'admin/kasir/form',
            'page_data' => [
                'mode' => 'edit',
                'kasir' => $kasir
            ],
            'bottom_nav' => $this->admin_bottom_nav('master')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $mode = $this->input->post('mode');
        $id = $this->input->post('id');

        $nama = $this->input->post('nama', TRUE);
        $no_hp = $this->input->post('no_hp', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $tipe_kasir = $this->input->post('tipe_kasir', TRUE);

        if ($mode == 'tambah') {
            if (!$no_hp) {
                $this->session->set_flashdata('error', 'Nomor HP wajib diisi untuk kasir baru.');
                redirect('admin/kasir/tambah');
            }
            if (!$password) {
                $this->session->set_flashdata('error', 'Password wajib diisi untuk kasir baru.');
                redirect('admin/kasir/tambah');
            }

            $data = [
                'nama' => $nama,
                'no_hp' => $no_hp,
                'username' => $username,
                'password' => md5($password),
                'tipe_kasir' => $tipe_kasir
            ];

            if ($this->User_model->create_kasir($data)) {
                $this->session->set_flashdata('success', 'Kasir berhasil ditambahkan.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal menambahkan kasir (username mungkin sudah digunakan).');
            }

            redirect('admin/kasir');
        }
        else {
            // edit
            $data = [
                'nama' => $nama,
                'no_hp' => $no_hp,
                'username' => $username,
                'tipe_kasir' => $tipe_kasir
            ];

            if ($no_hp) {
                $data['no_hp'] = $no_hp;
            }
            if ($password) {
                $data['password'] = md5($password);
            }

            if ($this->User_model->update_user($id, $data)) {
                $this->session->set_flashdata('success', 'Data kasir berhasil diupdate.');
            }
            else {
                $this->session->set_flashdata('error', 'Gagal mengupdate kasir.');
            }

            redirect('admin/kasir');
        }
    }

    public function hapus($id)
    {
        $kasir = $this->User_model->get_by_id($id);
        if (!$kasir || $kasir->role != 'kasir') {
            show_404();
        }

        $this->User_model->soft_delete($id);
        $this->session->set_flashdata('success', 'Kasir berhasil di-nonaktifkan.');
        redirect('admin/kasir');
    }
}

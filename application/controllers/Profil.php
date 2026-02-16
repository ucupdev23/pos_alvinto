<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Cek login untuk semua role (admin/kasir bisa akses)
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('User_model');
    }

    public function index()
    {
        redirect('profil/ganti_password');
    }

    public function ganti_password()
    {
        $role = $this->session->userdata('role');

        // Tentukan bottom nav berdasarkan role
        $bottom_nav = [];
        if ($role == 'admin') {
            $bottom_nav = $this->admin_bottom_nav(''); // tidak ada yang aktif
        }
        else {
            $bottom_nav = $this->kasir_bottom_nav('');
        }

        $data = [
            'title' => 'Ganti Password',
            'app_title' => 'Alvinto POS',
            'app_subtitle' => 'Ganti Password',
            'page' => 'profil/ganti_password',
            'bottom_nav' => $bottom_nav,
            'page_data' => []
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function update_password()
    {
        $old_pass = $this->input->post('old_password', TRUE);
        $new_pass = $this->input->post('new_password', TRUE);
        $confirm_pass = $this->input->post('confirm_password', TRUE);
        $user_id = $this->session->userdata('user_id');

        // Validasi input
        if (!$old_pass || !$new_pass || !$confirm_pass) {
            $this->session->set_flashdata('error', 'Semua kolom wajib diisi.');
            redirect('profil/ganti_password');
        }

        if ($new_pass !== $confirm_pass) {
            $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok.');
            redirect('profil/ganti_password');
        }

        // Cek password lama
        $cek = $this->User_model->cek_password_lama($user_id, $old_pass);
        if (!$cek) {
            $this->session->set_flashdata('error', 'Password lama salah.');
            redirect('profil/ganti_password');
        }

        // Update password
        $data = ['password' => md5($new_pass)];
        if ($this->User_model->update_user($user_id, $data)) {
            $this->session->set_flashdata('success', 'Password berhasil diubah.');
        }
        else {
            $this->session->set_flashdata('error', 'Gagal mengubah password.');
        }

        redirect('profil/ganti_password');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Transaksi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $today = date('Y-m-d');
        $tahun = date('Y');
        $bulan = date('m');

        $rekap_hari = $this->Transaksi_model->get_rekap_hari($today);
        $rekap_bulan = $this->Transaksi_model->get_rekap_bulan($tahun, $bulan);
        $top_hari = $this->Transaksi_model->get_top_karyawan_hari($today, 3);

        $data = [
            'title' => 'Dashboard Admin',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Ringkasan Usaha',
            'page' => 'admin/dashboard',
            'bottom_nav' => $this->admin_bottom_nav('home'),
            'page_data' => [
                'today' => $today,
                'rekap_hari' => $rekap_hari,
                'rekap_bulan' => $rekap_bulan,
                'top_hari' => $top_hari
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('kasir');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Kasir',
            'app_title' => 'Kasir Alvinto',
            'app_subtitle' => 'Menu Utama',
            'page' => 'kasir/dashboard',
            'bottom_nav' => $this->kasir_bottom_nav('home')
        ];

        $this->load->view('layouts/mobile', $data);
    }
}

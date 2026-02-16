<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('kasir');
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Kasir',
            'app_title' => 'Kasir Alvinto',
            'app_subtitle' => 'Menu Utama',
            'page' => 'kasir/dashboard',
            'bottom_nav'   => $this->kasir_bottom_nav('home')
        ];

        $this->load->view('layouts/mobile', $data);
    }
}

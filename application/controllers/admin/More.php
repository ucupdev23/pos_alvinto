<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class More extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('User_model');
    }

    public function index()
    {
        $data = [
            'title'        => 'Menu Lainnya',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Lainnya',
            'page'         => 'admin/more_index',
            'bottom_nav'   => $this->admin_bottom_nav('more'),
            'page_data'    => []
        ];

        $this->load->view('layouts/mobile', $data);
    }
}

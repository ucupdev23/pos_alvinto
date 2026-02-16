<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
    }

    public function index()
    {
        $data = [
            'title'        => 'Master Data',
            'app_title'    => 'Admin Alvinto',
            'app_subtitle' => 'Master Data',
            'page'         => 'admin/master_index',
            'bottom_nav'   => $this->admin_bottom_nav('master'),
            'page_data'    => []
        ];

        $this->load->view('layouts/mobile', $data);
    }
}

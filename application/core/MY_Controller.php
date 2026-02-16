<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    protected function require_login($role = null)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        if ($role && $this->session->userdata('role') != $role) {
            // kalau role tidak sesuai, lempar ke login
            redirect('auth');
        }
    }

    protected function admin_bottom_nav($active = 'home')
{
    return [
        [
            'label' => 'Home',
            'url'   => 'admin/dashboard',
            'icon'  => 'bi bi-speedometer2',
            'active'=> $active == 'home'
        ],
        [
            'label' => 'Master',
            'url'   => 'admin/master',
            'icon'  => 'bi bi-grid-3x3-gap',
            'active'=> $active == 'master'
        ],
        [
            'label' => 'Laporan',
            'url'   => 'admin/laporan',
            'icon'  => 'bi bi-clipboard-data',
            'active'=> $active == 'laporan'
        ],
        // [
        //     'label' => 'Lainnya',
        //     'url'   => 'admin/more',
        //     'icon'  => 'bi bi-three-dots',
        //     'active'=> $active == 'more'
        // ]
    ];
}

protected function kasir_bottom_nav($active = 'home')
{
    return [
        [
            'label' => 'Home',
            'url'   => 'kasir/dashboard',
            'icon'  => 'bi bi-house-door',
            'active'=> $active == 'home'
        ],
        [
            'label' => 'Transaksi',
            'url'   => 'kasir/transaksi',
            'icon'  => 'bi bi-plus-circle',
            'active'=> $active == 'transaksi'
        ],
        [
            'label' => 'Laporan',
            'url'   => 'kasir/laporan',
            'icon'  => 'bi bi-clipboard-data',
            'active'=> $active == 'laporan'
        ]
    ];
}

}

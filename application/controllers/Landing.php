<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_pangkas_model');
    }

    public function index()
    {
        // Ambil daftar layanan aktif dari database jika ada
        $layanan = [];
        try {
            $layanan = $this->Jenis_pangkas_model->get_all_active();
        } catch (Exception $e) {
            $layanan = [];
        }

        $data = [
            'title' => 'Alvinto Haircut - Barbershop Specialist Pria & Anak di Kota Bogor | Est. 2015',
            'layanan' => $layanan
        ];

        $this->load->view('landing', $data);
    }
}

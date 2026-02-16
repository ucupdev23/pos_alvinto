<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_kasir_model extends CI_Model {

    public function insert($data)
    {
        return $this->db->insert('gaji_kasir', $data);
    }

    public function get_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id = null)
    {
        $this->db->select('gaji_kasir.*, users.nama AS nama_kasir');
        $this->db->from('gaji_kasir');
        $this->db->join('users', 'users.id = gaji_kasir.kasir_id');
        if ($tanggal_mulai) {
            $this->db->where('gaji_kasir.tanggal >=', $tanggal_mulai);
        }
        if ($tanggal_selesai) {
            $this->db->where('gaji_kasir.tanggal <=', $tanggal_selesai);
        }
        if ($kasir_id) {
            $this->db->where('gaji_kasir.kasir_id', $kasir_id);
        }
        $this->db->order_by('gaji_kasir.tanggal', 'DESC');
        return $this->db->get()->result();
    }
}

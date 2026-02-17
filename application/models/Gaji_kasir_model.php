<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_kasir_model extends CI_Model
{

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

    public function check_existing($kasir_id, $tanggal)
    {
        $this->db->where('kasir_id', $kasir_id);
        $this->db->where('tanggal', $tanggal);
        return $this->db->get('gaji_kasir')->row();
    }

    public function get_by_id($id)
    {
        $this->db->select('gaji_kasir.*, users.nama AS nama_kasir, users.no_hp');
        $this->db->from('gaji_kasir');
        $this->db->join('users', 'users.id = gaji_kasir.kasir_id');
        $this->db->where('gaji_kasir.id', $id);
        return $this->db->get()->row();
    }

    public function get_total_gaji_kasir_by_date($date, $month = null, $year = null)
    {
        $this->db->select_sum('jumlah');
        if ($date) {
            $this->db->where('tanggal', $date);
        }
        if ($month && $year) {
            $this->db->where('MONTH(tanggal)', $month);
            $this->db->where('YEAR(tanggal)', $year);
        }
        $result = $this->db->get('gaji_kasir')->row();
        return $result ? (int)$result->jumlah : 0;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model {

    public function get_all_active()
    {
        $this->db->where('status', 1);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('karyawan')->result();
    }

    // UNTUK HALAMAN ADMIN
    public function get_all()
    {
        $this->db->order_by('status', 'DESC');
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('karyawan')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('karyawan', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('karyawan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('karyawan', $data);
    }

    public function soft_delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('karyawan', ['status' => 0]);
    }
}

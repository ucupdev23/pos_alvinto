<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pangkas_model extends CI_Model {

    public function get_all_active()
    {
        $this->db->where('status', 1);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('jenis_pangkas')->result();
    }

    public function get_all()
    {
        $this->db->order_by('status', 'DESC');
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('jenis_pangkas')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('jenis_pangkas', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('jenis_pangkas', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('jenis_pangkas', $data);
    }

    public function soft_delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('jenis_pangkas', ['status' => 0]);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan_uang_makan_model extends CI_Model {

    public function get_all()
    {
        $this->db->where('status', 1);
        $this->db->order_by('upah_min', 'ASC');
        return $this->db->get('aturan_uang_makan')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('aturan_uang_makan', ['id' => $id])->row();
    }

    public function create($data)
    {
        $data['status'] = 1;
        return $this->db->insert('aturan_uang_makan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('aturan_uang_makan', $data);
    }

    public function soft_delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('aturan_uang_makan', ['status' => 0]);
    }

    // 🔥 nanti dipakai di Transaksi_model
    public function get_by_upah($upah)
    {
        $this->db->where('status', 1);
        $this->db->where('upah_min <=', $upah);
        $this->db->group_start();
            $this->db->where('upah_max >=', $upah);
            $this->db->or_where('upah_max IS NULL', null, false);
        $this->db->group_end();
        $this->db->order_by('upah_min', 'DESC');
        $this->db->limit(1);

        return $this->db->get('aturan_uang_makan')->row();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aturan_uang_makan_kasir_model extends CI_Model
{

    public function get_all()
    {
        return $this->db->get('aturan_uang_makan_kasir')->result();
    }

    public function get_by_tipe($tipe_kasir)
    {
        return $this->db->get_where('aturan_uang_makan_kasir', ['tipe_kasir' => $tipe_kasir])->row();
    }

    public function update($tipe_kasir, $data)
    {
        $this->db->where('tipe_kasir', $tipe_kasir);
        return $this->db->update('aturan_uang_makan_kasir', $data);
    }
}

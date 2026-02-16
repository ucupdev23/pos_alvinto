<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', 1);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return null;
    }

    // === TAMBAHAN UNTUK ADMIN ===

    public function get_all_kasir()
    {
        $this->db->where('role', 'kasir');
        $this->db->where('status', 1);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('users')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function create_kasir($data)
    {
        $data['role'] = 'kasir';
        $data['status'] = 1;
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function soft_delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', ['status' => 0]);
    }

    public function cek_password_lama($user_id, $password)
    {
        $this->db->where('id', $user_id);
        $this->db->where('password', md5($password));
        return $this->db->get('users')->row();
    }

    // --- OTP Feature Methods ---

    public function get_by_username_or_phone($keyword)
    {
        $this->db->group_start();
        $this->db->where('username', $keyword);
        $this->db->or_where('no_hp', $keyword);
        $this->db->group_end();
        return $this->db->get('users')->row();
    }

    public function create_otp($user_id)
    {
        // Invalidate previous OTPs
        $this->db->where('user_id', $user_id);
        $this->db->where('is_used', 0);
        $this->db->update('user_otp', ['is_used' => 1]);

        // 6 digit random number
        $otp = rand(100000, 999999);

        // Expired +5 menit
        $expired_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Resend available +1 menit
        $resend_at = date('Y-m-d H:i:s', strtotime('+1 minute'));

        $data = [
            'user_id' => $user_id,
            'kode_otp' => $otp,
            'expired_at' => $expired_at,
            'resend_at' => $resend_at,
            'is_used' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('user_otp', $data);
        return $otp;
    }

    public function cek_otp($user_id, $otp)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('kode_otp', $otp);
        $this->db->where('is_used', 0);
        $this->db->where('expired_at >=', date('Y-m-d H:i:s'));
        $this->db->order_by('id', 'DESC');
        return $this->db->get('user_otp')->row();
    }

    public function mark_otp_used($otp_id)
    {
        $this->db->where('id', $otp_id);
        return $this->db->update('user_otp', ['is_used' => 1]);
    }

    public function update_password($user_id, $new_password)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['password' => md5($new_password)]);
    }
}

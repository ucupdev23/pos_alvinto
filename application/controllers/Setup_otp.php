<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup_otp extends CI_Controller
{

    public function index()
    {
        $this->load->database();

        $sql = "CREATE TABLE IF NOT EXISTS user_otp (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            kode_otp VARCHAR(50) NOT NULL,
            expired_at DATETIME NOT NULL,
            resend_at DATETIME  NULL,
            is_used TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (user_id),
            INDEX (kode_otp)
        )";

        if ($this->db->query($sql)) {
            echo "Table user_otp created successfully!";
        }
        else {
            echo "Failed to create table: " . $this->db->error()['message'];
        }
    }
}

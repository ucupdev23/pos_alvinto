<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migrate_gaji extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    // Hanya boleh dijalankan oleh admin atau via CLI jika perlu
    // $this->load->library('session');
    }

    public function index()
    {
        echo "<h1>Migration: Gaji Karyawan</h1>";

        // 1. Buat Tabel
        $this->_create_table();

        // 2. Backfill Data
        $this->_backfill_data();

        echo "<p>Migration Completed.</p>";
    }

    private function _create_table()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS `gaji_karyawan` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `karyawan_id` INT(11) NOT NULL,
                `tanggal` DATE NOT NULL,
                `total_omzet` INT(11) DEFAULT 0,
                `total_potong` INT(11) DEFAULT 0,
                `upah` INT(11) DEFAULT 0,
                `uang_makan` INT(11) DEFAULT 0,
                `total_gaji` INT(11) DEFAULT 0,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `unique_karyawan_tanggal` (`karyawan_id`, `tanggal`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if ($this->db->query($query)) {
            echo "<p>[OK] Table `gaji_karyawan` created or already exists.</p>";
        }
        else {
            echo "<p style='color:red'>[ERROR] Failed to create table: " . $this->db->error()['message'] . "</p>";
        }
    }

    private function _backfill_data()
    {
        $this->load->model('Transaksi_model');
        $this->load->model('Aturan_uang_makan_model');

        // Ambil semua tanggal dan karyawan yang ada transaksi
        $query = $this->db->query("
            SELECT DISTINCT tanggal, karyawan_id 
            FROM transaksi 
            ORDER BY tanggal ASC
        ");

        $dates = $query->result();

        echo "<p>Found " . count($dates) . " unique records (employee/date) to process.</p>";
        echo "<ul>";

        foreach ($dates as $d) {
            // Hitung ulang berdasarkan data transaksi saat ini
            $resume = $this->Transaksi_model->get_slip_karyawan($d->karyawan_id, $d->tanggal);

            if ($resume) {
                // Siapkan data insert
                $data = [
                    'karyawan_id' => $d->karyawan_id,
                    'tanggal' => $d->tanggal,
                    'total_omzet' => $resume['total_omzet'],
                    'total_potong' => 0, // Perlu query count tambahan jika mau exact, tapi opsional untuk now
                    'upah' => $resume['upah'],
                    'uang_makan' => $resume['uang_makan'],
                    'total_gaji' => $resume['total_gaji']
                ];

                // Tambahan hitung total potong biar lengkap
                $count = $this->db->where(['karyawan_id' => $d->karyawan_id, 'tanggal' => $d->tanggal])->count_all_results('transaksi');
                $data['total_potong'] = $count;

                // Insert or Update (ON DUPLICATE KEY UPDATE)
                $sql = $this->db->insert_string('gaji_karyawan', $data);
                $sql = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $sql);
                $this->db->query($sql);

                // Jika INSERT IGNORE tidak update, kita pakai replace manual atau on duplicate
                // Tapi karena struktur unik, kita bisa replace.
                $this->db->replace('gaji_karyawan', $data);
            }
        }

        echo "<li>Processed all records.</li>";
        echo "</ul>";
    }
}

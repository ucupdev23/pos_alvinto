<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Aturan_uang_makan_model');
    }

    public function insert_transaksi($kasir_id, $karyawan_id, $jenis_pangkas_id, $metode_pembayaran_id)
    {
        // Ambil harga dari jenis pangkas
        $jenis = $this->db->get_where('jenis_pangkas', ['id' => $jenis_pangkas_id, 'status' => 1])->row();
        if (!$jenis) {
            return false;
        }

        $data = [
            'tanggal' => date('Y-m-d'), // otomatis hari ini
            'kasir_id' => $kasir_id,
            'karyawan_id' => $karyawan_id,
            'jenis_pangkas_id' => $jenis_pangkas_id,
            'metode_pembayaran_id' => $metode_pembayaran_id,
            'harga' => $jenis->harga
        ];

        $inserted = $this->db->insert('transaksi', $data);

        if ($inserted) {
            return $this->db->insert_id();
        }

        return false;
    }

    public function get_transaksi_by_id($id)
    {
        $this->db->select('
            transaksi.*,
            users.nama AS nama_kasir,
            karyawan.nama AS nama_karyawan,
            jenis_pangkas.nama AS jenis_pangkas,
            metode_pembayaran.nama AS metode_bayar
        ');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.kasir_id');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->join('metode_pembayaran', 'metode_pembayaran.id = transaksi.metode_pembayaran_id');
        $this->db->where('transaksi.id', $id);
        return $this->db->get()->row();
    }

    public function save_gaji_if_not_exists($karyawan_id, $tanggal)
    {
        // 0. Cek dulu apakah sudah ada
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal', $tanggal);
        $exists = $this->db->count_all_results('gaji_karyawan');

        if ($exists > 0 && $tanggal !== date('Y-m-d')) {
            return; // Sudah ada dan bukan hari ini, jangan diapa-apain
        }

        // 1. Hitung total omzet & jumlah potong hari ini untuk karyawan tsb
        $this->db->select('SUM(harga) as total_omzet, COUNT(id) as total_potong');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal', $tanggal);
        $stat = $this->db->get('transaksi')->row();

        $total_omzet = $stat ? (int)$stat->total_omzet : 0;
        $total_potong = $stat ? (int)$stat->total_potong : 0;

        // 2. Hitung Upah (50%)
        $upah = $total_omzet * 0.5;

        // 3. Hitung Uang Makan (dari rules)
        $aturan = $this->Aturan_uang_makan_model->get_by_upah($upah);
        $uang_makan = $aturan ? (int)$aturan->uang_makan : 0;

        // 4. Total Gaji
        $total_gaji = $upah + $uang_makan;

        // 5. Insert atau Update ke tabel gaji_karyawan
        $data_gaji = [
            'karyawan_id' => $karyawan_id,
            'tanggal' => $tanggal,
            'total_omzet' => $total_omzet,
            'total_potong' => $total_potong,
            'upah' => $upah,
            'uang_makan' => $uang_makan,
            'total_gaji' => $total_gaji
        ];

        if ($exists > 0) {
            $this->db->where('karyawan_id', $karyawan_id);
            $this->db->where('tanggal', $tanggal);
            $this->db->update('gaji_karyawan', $data_gaji);
        } else {
            $this->db->insert('gaji_karyawan', $data_gaji);
        }
    }



    // Hitung slip gaji karyawan per hari
    public function get_slip_karyawan($karyawan_id, $tanggal)
    {
        $this->db->select('
            karyawan.nama AS nama_karyawan,
            transaksi.tanggal,
            SUM(transaksi.harga) AS total_omzet
        ');
        $this->db->from('transaksi');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->where('transaksi.karyawan_id', $karyawan_id);
        $this->db->where('transaksi.tanggal', $tanggal);
        $this->db->group_by('transaksi.karyawan_id, transaksi.tanggal');

        $row = $this->db->get()->row();

        if (!$row) {
            return null;
        }

        $upah = $row->total_omzet * 0.5;

        // if ($upah > 100000) {
        //     $uang_makan = 30000;
        // } else {
        //     $uang_makan = 25000;
        // }

        $aturan = $this->Aturan_uang_makan_model->get_by_upah($upah);
        $uang_makan = $aturan ? (int)$aturan->uang_makan : 0;

        $total_gaji = $upah + $uang_makan;

        return [
            'nama_karyawan' => $row->nama_karyawan,
            'tanggal' => $row->tanggal,
            'total_omzet' => $row->total_omzet,
            'upah' => $upah,
            'uang_makan' => $uang_makan,
            'total_gaji' => $total_gaji
        ];
    }

    // Optional: detail transaksi hari itu
    public function get_transaksi_karyawan_harian($karyawan_id, $tanggal)
    {
        $this->db->select('transaksi.*, jenis_pangkas.nama AS jenis_pangkas, metode_pembayaran.nama AS metode_bayar');
        $this->db->from('transaksi');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->join('metode_pembayaran', 'metode_pembayaran.id = transaksi.metode_pembayaran_id');
        $this->db->where('transaksi.karyawan_id', $karyawan_id);
        $this->db->where('transaksi.tanggal', $tanggal);
        $this->db->order_by('transaksi.id', 'ASC');

        return $this->db->get()->result();
    }

    // Laporan transaksi dengan filter
    public function get_laporan_transaksi(
        $tanggal_mulai,
        $tanggal_selesai,
        $kasir_id = null,
        $karyawan_id = null,
        $metode_id = null,
        $limit = null,
        $offset = null
        )
    {
        $this->db->select('
        transaksi.*,
        users.nama AS nama_kasir,
        karyawan.nama AS nama_karyawan,
        jenis_pangkas.nama AS jenis_pangkas,
        metode_pembayaran.nama AS metode_bayar
    ');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.kasir_id');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->join('metode_pembayaran', 'metode_pembayaran.id = transaksi.metode_pembayaran_id');

        if ($tanggal_mulai) {
            $this->db->where('transaksi.tanggal >=', $tanggal_mulai);
        }
        if ($tanggal_selesai) {
            $this->db->where('transaksi.tanggal <=', $tanggal_selesai);
        }
        if ($kasir_id) {
            $this->db->where('transaksi.kasir_id', $kasir_id);
        }
        if ($karyawan_id) {
            $this->db->where('transaksi.karyawan_id', $karyawan_id);
        }
        if ($metode_id) {
            $this->db->where('transaksi.metode_pembayaran_id', $metode_id);
        }

        $this->db->order_by('transaksi.tanggal', 'ASC');
        $this->db->order_by('transaksi.id', 'ASC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    // Rekap omzet di periode
    public function get_rekap_omzet($tanggal_mulai, $tanggal_selesai)
    {
        $this->db->select('
        SUM(harga) AS total_omzet,
        COUNT(id) AS total_potong
    ');
        $this->db->from('transaksi');

        if ($tanggal_mulai) {
            $this->db->where('tanggal >=', $tanggal_mulai);
        }
        if ($tanggal_selesai) {
            $this->db->where('tanggal <=', $tanggal_selesai);
        }

        return $this->db->get()->row();
    }
    public function get_rekap_kasir_harian($kasir_id, $tanggal)
    {
        // Ambil omzet per karyawan untuk kasir & tanggal tertentu
        $this->db->select('
        karyawan.id AS karyawan_id,
        karyawan.nama AS nama_karyawan,
        SUM(transaksi.harga) AS total_omzet_karyawan
    ');
        $this->db->from('transaksi');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->where('transaksi.kasir_id', $kasir_id);
        $this->db->where('transaksi.tanggal', $tanggal);
        $this->db->group_by('karyawan.id, karyawan.nama');
        $rows = $this->db->get()->result();

        if (empty($rows)) {
            return null; // tidak ada transaksi
        }

        $rekap = [
            'per_karyawan' => [],
            'total_omzet' => 0,
            'total_gaji_karyawan' => 0,
            'saldo' => 0
        ];

        foreach ($rows as $row) {
            $omzet = (int)$row->total_omzet_karyawan;
            $upah = $omzet * 0.5;

            // gaji karyawan = upah + uang makan
            // if ($upah > 100000) {
            //     $uang_makan = 30000;
            // } else {
            //     $uang_makan = 25000;
            // }

            $aturan = $this->Aturan_uang_makan_model->get_by_upah($upah);
            $uang_makan = $aturan ? (int)$aturan->uang_makan : 0;

            $total_gaji = $upah + $uang_makan;

            $rekap['per_karyawan'][] = [
                'karyawan_id' => $row->karyawan_id,
                'nama_karyawan' => $row->nama_karyawan,
                'omzet' => $omzet,
                'upah' => $upah,
                'uang_makan' => $uang_makan,
                'total_gaji' => $total_gaji
            ];

            $rekap['total_omzet'] += $omzet;
            $rekap['total_gaji_karyawan'] += $total_gaji;
        }

        $rekap['saldo'] = $rekap['total_omzet'] - $rekap['total_gaji_karyawan'];

        return $rekap;
    }

    // Omzet & jumlah potongan hari ini
    public function get_rekap_hari($tanggal)
    {
        $this->db->select('SUM(harga) AS total_omzet, COUNT(id) AS total_potong');
        $this->db->from('transaksi');
        $this->db->where('tanggal', $tanggal);
        $row = $this->db->get()->row();

        return [
            'total_omzet' => $row && $row->total_omzet ? (int)$row->total_omzet : 0,
            'total_potong' => $row && $row->total_potong ? (int)$row->total_potong : 0,
            'total_potong' => $row && $row->total_potong ? (int)$row->total_potong : 0,
        ];
    }

    // Total gaji karyawan (dari tabel gaji_karyawan)
    public function get_total_gaji_karyawan_by_date($date, $month = null, $year = null)
    {
        $this->db->select_sum('total_gaji');
        if ($date) {
            $this->db->where('tanggal', $date);
        }
        if ($month && $year) {
            $this->db->where('MONTH(tanggal)', $month);
            $this->db->where('YEAR(tanggal)', $year);
        }
        $result = $this->db->get('gaji_karyawan')->row();
        return $result ? (int)$result->total_gaji : 0;
    }

    // Omzet & jumlah potongan per bulan
    public function get_rekap_bulan($tahun, $bulan)
    {
        $this->db->select('SUM(harga) AS total_omzet, COUNT(id) AS total_potong');
        $this->db->from('transaksi');
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('MONTH(tanggal)', $bulan);
        $row = $this->db->get()->row();

        return [
            'total_omzet' => $row && $row->total_omzet ? (int)$row->total_omzet : 0,
            'total_potong' => $row && $row->total_potong ? (int)$row->total_potong : 0,

        ];
    }
    // Grafik 7 hari terakhir (Omzet & Keuntungan)
    public function get_rekap_mingguan($Gaji_kasir_model)
    {
        // 7 hari terakhir
        $result = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            // Omzet
            $rekap = $this->get_rekap_hari($date);
            $omzet = $rekap['total_omzet'];

            // Pengeluaran
            $gaji_karyawan = $this->get_total_gaji_karyawan_by_date($date);
            $gaji_kasir = $Gaji_kasir_model->get_total_gaji_kasir_by_date($date);

            $keuntungan = $omzet - ($gaji_karyawan + $gaji_kasir);

            $result[] = [
                'tanggal' => date('d/m', strtotime($date)), // Format label: 18/02
                'omzet' => $omzet,
                'keuntungan' => $keuntungan
            ];
        }
        return $result;
    }

    // Top karyawan berdasarkan omzet di tanggal tertentu
    public function get_top_karyawan_hari($tanggal, $limit = 3)
    {
        $this->db->select('
        karyawan.nama AS nama_karyawan,
        SUM(transaksi.harga) AS total_omzet,
        COUNT(transaksi.id) AS total_potong
    ');
        $this->db->from('transaksi');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->where('transaksi.tanggal', $tanggal);
        $this->db->group_by('karyawan.id, karyawan.nama');
        $this->db->order_by('total_omzet', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Top karyawan bulan ini
    public function get_top_karyawan_bulan($tahun, $bulan, $limit = 3)
    {
        $this->db->select('
            karyawan.nama AS nama_karyawan,
            SUM(transaksi.harga) AS total_omzet,
            COUNT(transaksi.id) AS total_potong
        ');
        $this->db->from('transaksi');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->where('YEAR(transaksi.tanggal)', $tahun);
        $this->db->where('MONTH(transaksi.tanggal)', $bulan);
        $this->db->group_by('karyawan.id, karyawan.nama');
        $this->db->order_by('total_omzet', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    public function count_laporan_transaksi($tanggal_mulai, $tanggal_selesai, $kasir_id = null, $karyawan_id = null, $metode_id = null)
    {
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.kasir_id');
        $this->db->join('karyawan', 'karyawan.id = transaksi.karyawan_id');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->join('metode_pembayaran', 'metode_pembayaran.id = transaksi.metode_pembayaran_id');

        if ($tanggal_mulai) {
            $this->db->where('transaksi.tanggal >=', $tanggal_mulai);
        }
        if ($tanggal_selesai) {
            $this->db->where('transaksi.tanggal <=', $tanggal_selesai);
        }
        if ($kasir_id) {
            $this->db->where('transaksi.kasir_id', $kasir_id);
        }
        if ($karyawan_id) {
            $this->db->where('transaksi.karyawan_id', $karyawan_id);
        }
        if ($metode_id) {
            $this->db->where('transaksi.metode_pembayaran_id', $metode_id);
        }

        return $this->db->count_all_results();
    }
    public function get_transaksi_karyawan_harian_grouped($karyawan_id, $tanggal)
    {
        $this->db->select('
        jenis_pangkas.nama AS jenis_pangkas,
        metode_pembayaran.nama AS metode_bayar,
        COUNT(transaksi.id) AS qty,
        SUM(transaksi.harga) AS total_harga
    ');
        $this->db->from('transaksi');
        $this->db->join('jenis_pangkas', 'jenis_pangkas.id = transaksi.jenis_pangkas_id');
        $this->db->join('metode_pembayaran', 'metode_pembayaran.id = transaksi.metode_pembayaran_id');
        $this->db->where('transaksi.karyawan_id', $karyawan_id);
        $this->db->where('transaksi.tanggal', $tanggal);
        $this->db->group_by('transaksi.jenis_pangkas_id, transaksi.metode_pembayaran_id');
        $this->db->order_by('jenis_pangkas.nama', 'ASC');

        return $this->db->get()->result();
    }

    public function truncate_all_transactions()
    {
        $this->db->truncate('transaksi');
        $this->db->truncate('gaji_karyawan');
        $this->db->truncate('gaji_kasir');
        return true;
    }

    public function recalculate_gaji_karyawan($karyawan_id, $tanggal)
    {
        // 1. Hitung total omzet & jumlah potong hari ini untuk karyawan tsb
        $this->db->select('SUM(harga) as total_omzet, COUNT(id) as total_potong');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal', $tanggal);
        $stat = $this->db->get('transaksi')->row();

        $total_omzet = $stat ? (int)$stat->total_omzet : 0;
        $total_potong = $stat ? (int)$stat->total_potong : 0;

        if ($total_potong == 0) {
            // Hapus data gaji karyawan untuk tanggal ini karena sudah tidak ada transaksi
            $this->db->where('karyawan_id', $karyawan_id);
            $this->db->where('tanggal', $tanggal);
            $this->db->delete('gaji_karyawan');
            return;
        }

        // 2. Hitung Upah (50%)
        $upah = $total_omzet * 0.5;

        // 3. Hitung Uang Makan (dari rules)
        $aturan = $this->Aturan_uang_makan_model->get_by_upah($upah);
        $uang_makan = $aturan ? (int)$aturan->uang_makan : 0;

        // 4. Total Gaji
        $total_gaji = $upah + $uang_makan;

        // 5. Insert atau Update ke tabel gaji_karyawan
        $data_gaji = [
            'karyawan_id' => $karyawan_id,
            'tanggal' => $tanggal,
            'total_omzet' => $total_omzet,
            'total_potong' => $total_potong,
            'upah' => $upah,
            'uang_makan' => $uang_makan,
            'total_gaji' => $total_gaji
        ];

        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal', $tanggal);
        $exists = $this->db->count_all_results('gaji_karyawan');

        if ($exists > 0) {
            $this->db->where('karyawan_id', $karyawan_id);
            $this->db->where('tanggal', $tanggal);
            $this->db->update('gaji_karyawan', $data_gaji);
        } else {
            $this->db->insert('gaji_karyawan', $data_gaji);
        }
    }

    public function update_transaksi($id, $karyawan_id, $jenis_pangkas_id, $metode_pembayaran_id)
    {
        // Ambil data asli transaksi sebelum diupdate
        $tx = $this->db->get_where('transaksi', ['id' => $id])->row();
        if (!$tx) {
            return false;
        }

        $old_karyawan_id = $tx->karyawan_id;
        $old_tanggal = $tx->tanggal;

        // Ambil harga baru dari jenis pangkas
        $jenis = $this->db->get_where('jenis_pangkas', ['id' => $jenis_pangkas_id, 'status' => 1])->row();
        if (!$jenis) {
            return false;
        }

        $data = [
            'karyawan_id' => $karyawan_id,
            'jenis_pangkas_id' => $jenis_pangkas_id,
            'metode_pembayaran_id' => $metode_pembayaran_id,
            'harga' => $jenis->harga
        ];

        $this->db->where('id', $id);
        $updated = $this->db->update('transaksi', $data);

        if ($updated) {
            // Kalkulasi ulang gaji karyawan lama
            $this->recalculate_gaji_karyawan($old_karyawan_id, $old_tanggal);

            // Jika karyawannya berubah, kalkulasi juga untuk yang baru
            if ($old_karyawan_id != $karyawan_id) {
                $this->recalculate_gaji_karyawan($karyawan_id, $old_tanggal);
            }
            return true;
        }

        return false;
    }

    public function delete_transaksi($id)
    {
        // Ambil data transaksi dulu untuk tau karyawan_id dan tanggal
        $tx = $this->db->get_where('transaksi', ['id' => $id])->row();
        if ($tx) {
            $karyawan_id = $tx->karyawan_id;
            $tanggal = $tx->tanggal;

            // Hapus transaksi
            $this->db->where('id', $id);
            $this->db->delete('transaksi');

            // Kalkulasi ulang gaji karyawan
            $this->recalculate_gaji_karyawan($karyawan_id, $tanggal);
            return true;
        }
        return false;
    }

    public function delete_transaksi_batch($ids)
    {
        if (empty($ids)) {
            return false;
        }

        // Ambil data semua transaksi yang akan dihapus untuk mengidentifikasi karyawan & tanggal yang terpengaruh
        $this->db->select('karyawan_id, tanggal');
        $this->db->where_in('id', $ids);
        $txs = $this->db->get('transaksi')->result();

        $affected = [];
        foreach ($txs as $tx) {
            $key = $tx->karyawan_id . '|' . $tx->tanggal;
            $affected[$key] = [
                'karyawan_id' => $tx->karyawan_id,
                'tanggal' => $tx->tanggal
            ];
        }

        // Hapus
        $this->db->where_in('id', $ids);
        $this->db->delete('transaksi');

        // Kalkulasi ulang gaji karyawan yang terpengaruh
        foreach ($affected as $a) {
            $this->recalculate_gaji_karyawan($a['karyawan_id'], $a['tanggal']);
        }

        return true;
    }

    public function delete_transaksi_by_filter($tanggal_mulai, $tanggal_selesai, $kasir_id = null, $karyawan_id = null, $metode_id = null)
    {
        // Cari transaksi yang sesuai filter
        $this->db->select('id, karyawan_id, tanggal');
        $this->db->from('transaksi');
        if ($tanggal_mulai) {
            $this->db->where('tanggal >=', $tanggal_mulai);
        }
        if ($tanggal_selesai) {
            $this->db->where('tanggal <=', $tanggal_selesai);
        }
        if ($kasir_id) {
            $this->db->where('kasir_id', $kasir_id);
        }
        if ($karyawan_id) {
            $this->db->where('karyawan_id', $karyawan_id);
        }
        if ($metode_id) {
            $this->db->where('metode_pembayaran_id', $metode_id);
        }

        $txs = $this->db->get()->result();
        if (empty($txs)) {
            return false;
        }

        $ids = array_column($txs, 'id');
        return $this->delete_transaksi_batch($ids);
    }

}


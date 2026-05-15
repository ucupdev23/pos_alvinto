<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Endpoint publik untuk aplikasi Printer Thermal Bluetooth
     * Format: /cetak/struk_json/{id}?bayar=xxx&kembalian=xxx
     * Tidak memerlukan login karena diakses oleh aplikasi pihak ketiga
     */
    public function struk_json($id = null)
    {
        if (!$id) {
            if (ob_get_length())
                ob_clean();
            header('Content-Type: application/json');
            echo json_encode(["error" => "ID tidak valid"]);
            exit;
        }

        $transaksi = $this->Transaksi_model->get_transaksi_by_id($id);
        if (!$transaksi) {
            if (ob_get_length())
                ob_clean();
            header('Content-Type: application/json');
            echo json_encode(["error" => "Data tidak ditemukan"]);
            exit;
        }

        $bayar = (float) ($this->input->get('bayar') ?: 0);
        $kembalian = (float) ($this->input->get('kembalian') ?: 0);

        $a = array();

        $add_text = function ($content, $bold = 0, $align = 0, $format = 0) use (&$a) {
            $obj = new stdClass();
            $obj->type = 0;
            $obj->content = $content;
            $obj->bold = $bold;
            $obj->align = $align;
            $obj->format = $format;
            array_push($a, $obj);
        };

        $add_html = function ($content) use (&$a) {
            $obj = new stdClass();
            $obj->type = 4;
            $obj->content = $content;
            array_push($a, $obj);
        };

        $format_lr = function ($left, $right, $width = 32) {
            $len_left = strlen($left);
            $len_right = strlen($right);
            $spaces = $width - $len_left - $len_right;
            if ($spaces < 1)
                $spaces = 1;
            return $left . str_repeat(' ', $spaces) . $right;
        };

        // === Jarak Atas ===
        $add_text(' ', 0, 0, 0);
        $add_text(' ', 0, 0, 0);

        // === Header ===
        $add_html('<center><span style="font-weight:bold; font-size:26px;">ALVINTO HAIRCUT</span></center>');
        $add_html('<center><span style="font-size:12px;">-- specialist men & kids --</span></center>');
        $add_text(' ', 0, 0, 0);

        // === Nama Barber ===
        $add_text($format_lr('Nama Barber', $transaksi->nama_karyawan), 0, 0, 0);
        $add_text('--------------------------------', 0, 0, 0);

        // === Detail Transaksi ===
        $add_text($format_lr('Date', date('d/m/Y', strtotime($transaksi->tanggal))), 1, 0, 0);
        $add_text($format_lr('Tarif ' . $transaksi->jenis_pangkas, 'Rp.' . number_format($transaksi->harga, 0, ',', '.')), 0, 0, 0);
        $add_text($format_lr('Pembayaran', $transaksi->metode_bayar), 0, 0, 0);
        $add_text('--------------------------------', 0, 0, 0);

        // === Bayar & Kembalian (Cash only) ===
        if ($transaksi->metode_pembayaran_id == 1 && $bayar) {
            $add_text($format_lr('Bayar', 'Rp.' . number_format($bayar, 0, ',', '.')), 0, 0, 0);
            $add_text($format_lr('Kembalian', 'Rp.' . number_format($kembalian, 0, ',', '.')), 0, 0, 0);
            $add_text($format_lr('Nama Kasir', $transaksi->nama_kasir), 0, 0, 0);
            $add_text('--------------------------------', 0, 0, 0);
        } else {
            $add_text($format_lr('Nama Kasir', $transaksi->nama_kasir), 0, 0, 0);
            $add_text('--------------------------------', 0, 0, 0);
        }

        // === Footer ===
        $add_text(' ', 0, 0, 0);
        $add_text('TERIMA KASIH ATAS KUNJUNGAN ANDA', 0, 1, 4); // small, center
        $add_text(' ', 0, 0, 0);

        // Logo (dengan jarak atas-bawah)
        $obj2 = new stdClass();
        $obj2->type = 1;
        $obj2->path = base_url('assets/logo.png');
        $obj2->align = 1;
        array_push($a, $obj2);

        $add_text(' ', 0, 0, 0);
        $add_html('<center><span style="font-weight:bold; font-size:16px;">WhatsApp :</span></center>');
        $add_html('<center><span style="font-weight:bold; font-size:14px;">(087770077254) - (087870708254)</span></center>');
        $add_text(' ', 0, 0, 0);
        $add_text(' ', 0, 0, 0);

        if (ob_get_length())
            ob_clean();
        header('Content-Type: application/json');
        echo json_encode($a, JSON_FORCE_OBJECT);
        exit;
    }
}

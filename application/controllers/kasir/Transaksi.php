<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('kasir');
        $this->load->model('Karyawan_model');
        $this->load->model('Jenis_pangkas_model');
        $this->load->model('Metode_pembayaran_model');
        $this->load->model('Transaksi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $today = date('Y-m-d');
        $kasir_id = $this->session->userdata('user_id');

        $data = [
            'title' => 'Input Transaksi',
            'app_title' => 'Kasir Alvinto',
            'app_subtitle' => 'Input Transaksi',
            'bottom_nav' => $this->kasir_bottom_nav('transaksi'),
            'page' => 'kasir/transaksi_form',
            'page_data' => [
                'karyawan' => $this->Karyawan_model->get_all_active(),
                'jenis_pangkas' => $this->Jenis_pangkas_model->get_all_active(),
                'metode_bayar' => $this->Metode_pembayaran_model->get_all_active(),
                'tanggal_hari_ini' => $today,
                'transaksi_hari_ini' => $this->Transaksi_model->get_laporan_transaksi($today, $today, $kasir_id)
            ]
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $karyawan_id = $this->input->post('karyawan_id', TRUE);
        $jenis_pangkas_id = $this->input->post('jenis_pangkas_id', TRUE);
        $metode_pembayaran_id = $this->input->post('metode_pembayaran_id', TRUE);
        $kasir_id = $this->session->userdata('user_id');

        if (!$karyawan_id || !$jenis_pangkas_id || !$metode_pembayaran_id) {
            $this->session->set_flashdata('error', 'Harap lengkapi semua kolom.');
            redirect('kasir/transaksi');
        }

        $insert_id = $this->Transaksi_model->insert_transaksi(
            $kasir_id,
            $karyawan_id,
            $jenis_pangkas_id,
            $metode_pembayaran_id
        );

        if ($insert_id) {
            $this->session->set_flashdata('success', 'Transaksi berhasil disimpan.');
            $this->session->set_flashdata('print_struk_id', $insert_id);
            $this->session->set_flashdata('bayar', $this->input->post('bayar'));
            $this->session->set_flashdata('kembalian', $this->input->post('kembalian'));
        }
        else {
            $this->session->set_flashdata('error', 'Gagal menyimpan transaksi.');
        }

        redirect('kasir/transaksi');
    }

    public function update($id)
    {
        $karyawan_id = $this->input->post('karyawan_id', TRUE);
        $jenis_pangkas_id = $this->input->post('jenis_pangkas_id', TRUE);
        $metode_pembayaran_id = $this->input->post('metode_pembayaran_id', TRUE);

        if (!$karyawan_id || !$jenis_pangkas_id || !$metode_pembayaran_id) {
            $this->session->set_flashdata('error', 'Harap lengkapi semua kolom.');
            redirect('kasir/transaksi');
        }

        $updated = $this->Transaksi_model->update_transaksi(
            $id,
            $karyawan_id,
            $jenis_pangkas_id,
            $metode_pembayaran_id
        );

        if ($updated) {
            $this->session->set_flashdata('success', 'Transaksi berhasil diperbarui.');
            // Jika ada info bayar & kembalian untuk struk
            if ($this->input->post('bayar') !== '') {
                $this->session->set_flashdata('print_struk_id', $id);
                $this->session->set_flashdata('bayar', $this->input->post('bayar'));
                $this->session->set_flashdata('kembalian', $this->input->post('kembalian'));
            }
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui transaksi.');
        }

        redirect('kasir/transaksi');
    }

    public function hapus($id)
    {
        $deleted = $this->Transaksi_model->delete_transaksi($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Transaksi berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus transaksi.');
        }

        redirect('kasir/transaksi');
    }

    public function struk($id)
    {
        $transaksi = $this->Transaksi_model->get_transaksi_by_id($id);
        if (!$transaksi) {
            show_404();
        }

        $bayar = $this->input->get('bayar');
        $kembalian = $this->input->get('kembalian');

        $data = [
            'transaksi' => $transaksi,
            'bayar' => $bayar,
            'kembalian' => $kembalian
        ];

        $this->load->view('kasir/struk', $data);
    }

    public function struk_json($id)
    {
        $transaksi = $this->Transaksi_model->get_transaksi_by_id($id);
        if (!$transaksi) {
            echo json_encode(['error' => 'Data tidak ditemukan']);
            return;
        }

        $bayar = (float)($this->input->get('bayar') ?: 0);
        $kembalian = (float)($this->input->get('kembalian') ?: 0);

        $a = array();

        $add_text = function($content, $bold=0, $align=0, $format=0) use (&$a) {
            $obj = new stdClass();
            $obj->type = 0;
            $obj->content = $content;
            $obj->bold = $bold;
            $obj->align = $align;
            $obj->format = $format;
            array_push($a, $obj);
        };

        // Header
        $add_text('ALVINTO HAIRCUT', 1, 1, 1);
        $add_text('-- specialist men & kids --', 0, 1, 0);
        $add_text(' ', 0, 0, 0);
        
        // Info
        $add_text('Nama Barber : ' . $transaksi->nama_karyawan, 0, 0, 0);
        $add_text('--------------------------------', 0, 0, 0);
        $add_text('Date: ' . date('d/m/Y', strtotime($transaksi->tanggal)), 1, 0, 0);
        $add_text($transaksi->jenis_pangkas . ' : Rp.' . number_format($transaksi->harga, 0, ',', '.'), 0, 0, 0);
        $add_text('Pembayaran : ' . $transaksi->metode_bayar, 0, 0, 0);
        $add_text('--------------------------------', 0, 0, 0);

        if ($transaksi->metode_pembayaran_id == 1 && $bayar) {
            $add_text('Bayar : Rp.' . number_format($bayar, 0, ',', '.'), 0, 0, 0);
            $add_text('Kembalian : Rp.' . number_format($kembalian, 0, ',', '.'), 0, 0, 0);
        }
        $add_text('Nama Kasir : ' . $transaksi->nama_kasir, 0, 0, 0);
        $add_text('--------------------------------', 0, 0, 0);
        $add_text('TERIMA KASIH ATAS KUNJUNGAN ANDA', 0, 1, 0);

        // Image
        $obj2 = new stdClass();	
        $obj2->type = 1;
        $obj2->path = base_url('assets/logo.png');
        $obj2->align = 1;
        array_push($a, $obj2);

        $add_text('WhatsApp : (087770077254)-(087870708254)', 1, 1, 0);

        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        echo json_encode($a, JSON_FORCE_OBJECT);
        exit;
    }
}

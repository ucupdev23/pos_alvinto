<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_kasir extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_login('admin');
        $this->load->model('Gaji_kasir_model');
        $this->load->model('User_model');
        $this->load->model('Transaksi_model'); // <--- tambahkan ini
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        // Filter list gaji kasir (periode)
        $tanggal_mulai = $this->input->get('tanggal_mulai') ?: date('Y-m-01');
        $tanggal_selesai = $this->input->get('tanggal_selesai') ?: date('Y-m-d');
        $kasir_id_filter = $this->input->get('kasir_id');

        $gaji_list = $this->Gaji_kasir_model->get_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id_filter);

        // Kalkulator saldo harian kasir
        $kasir_hari_id = $this->input->get('kasir_hari_id');
        $tanggal_hari = $this->input->get('tanggal_hari') ?: date('Y-m-d');
        $rekap_harian = null;

        if ($kasir_hari_id && $tanggal_hari) {
            $rekap_harian = $this->Transaksi_model->get_rekap_kasir_harian($kasir_hari_id, $tanggal_hari);
        }

        $data = [
            'title' => 'Gaji Kasir',
            'app_title' => 'Admin Alvinto',
            'app_subtitle' => 'Input & Laporan Gaji Kasir',
            'page' => 'admin/gaji_kasir_index',
            'page_data' => [
                'gaji_list' => $gaji_list,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'kasir_id_filter' => $kasir_id_filter,
                'kasir_list' => $this->User_model->get_all_kasir(),
                // data buat kalkulator saldo
                'kasir_hari_id' => $kasir_hari_id,
                'tanggal_hari' => $tanggal_hari,
                'rekap_harian' => $rekap_harian
            ],
            'bottom_nav' => $this->admin_bottom_nav('more')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $tanggal = $this->input->post('tanggal', TRUE);
        $kasir_id = $this->input->post('kasir_id', TRUE);
        $jumlah = $this->input->post('jumlah', TRUE);
        $catatan = $this->input->post('catatan', TRUE);

        if (!$tanggal || !$kasir_id || !$jumlah) {
            $this->session->set_flashdata('error', 'Tanggal, kasir, dan jumlah wajib diisi.');
            redirect('admin/gaji_kasir');
        }

        // Check duplicate payment
        $existing = $this->Gaji_kasir_model->check_existing($kasir_id, $tanggal);
        if ($existing) {
            $this->session->set_flashdata('error', 'Kasir ini sudah digaji pada tanggal tersebut.');
            redirect('admin/gaji_kasir');
        }

        $data = [
            'tanggal' => $tanggal,
            'kasir_id' => $kasir_id,
            'jumlah' => $jumlah,
            'catatan' => $catatan
        ];

        if ($this->Gaji_kasir_model->insert($data)) {
            // Get last insert ID
            $gaji_id = $this->db->insert_id();

            // Get kasir data for WA
            $gaji = $this->Gaji_kasir_model->get_by_id($gaji_id);

            // Send WhatsApp slip
            if ($gaji && !empty($gaji->no_hp)) {
                $this->_send_slip_wa($gaji);
                $this->session->set_flashdata('success', 'Gaji kasir berhasil disimpan & slip gaji telah dikirim ke WhatsApp.');
            }
            else {
                $this->session->set_flashdata('success', 'Gaji kasir berhasil disimpan. (No HP kasir tidak ditemukan, slip WA tidak dikirim)');
            }
        }
        else {
            $this->session->set_flashdata('error', 'Gagal menyimpan gaji kasir.');
        }

        redirect('admin/gaji_kasir');
    }

    public function resend_slip($gaji_id)
    {
        $gaji = $this->Gaji_kasir_model->get_by_id($gaji_id);

        if (!$gaji) {
            echo json_encode(['status' => false, 'message' => 'Data gaji tidak ditemukan']);
            return;
        }

        if (empty($gaji->no_hp)) {
            echo json_encode(['status' => false, 'message' => 'No HP kasir tidak ditemukan']);
            return;
        }

        $this->_send_slip_wa($gaji);
        echo json_encode(['status' => true, 'message' => 'Slip gaji berhasil dikirim ulang']);
    }

    private function _send_slip_wa($gaji)
    {
        $message = "*SLIP GAJI KASIR - ALVINTO POS*\n\n";
        $message .= "Kepada: *{$gaji->nama_kasir}*\n";
        $message .= "Tanggal: " . date('d/m/Y', strtotime($gaji->tanggal)) . "\n";
        $message .= "Jumlah: *Rp " . number_format($gaji->jumlah, 0, ',', '.') . "*\n";
        if (!empty($gaji->catatan)) {
            $message .= "Catatan: {$gaji->catatan}\n";
        }
        $message .= "\n_Terima kasih atas kerja keras Anda!_ 🙏";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $gaji->no_hp,
                'message' => $message,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . FONNTE_TOKEN
            ),
        ));

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
}

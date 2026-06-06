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
        $this->load->model('Transaksi_model');
        $this->load->model('Aturan_uang_makan_kasir_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        // Filter list gaji kasir (periode)
        $tanggal_mulai = $this->input->get('tanggal_mulai') ?: date('Y-m-01');
        $tanggal_selesai = $this->input->get('tanggal_selesai') ?: date('Y-m-d');
        $kasir_id_filter = $this->input->get('kasir_id');

        $gaji_list = $this->Gaji_kasir_model->get_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id_filter);

        $summary_periode = null;
        if ($tanggal_mulai && $tanggal_selesai && $kasir_id_filter && !empty($gaji_list)) {
            $summary_periode = $this->Gaji_kasir_model->get_summary_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id_filter);
        }

        // Kalkulator saldo harian kasir
        $kasir_hari_id = $this->input->get('kasir_hari_id');
        $tanggal_hari = $this->input->get('tanggal_hari') ?: date('Y-m-d');
        $rekap_harian = null;

        $tipe_kasir_hari = null;
        if ($kasir_hari_id && $tanggal_hari) {
            $rekap_harian = $this->Transaksi_model->get_rekap_kasir_harian($kasir_hari_id, $tanggal_hari);
            if ($rekap_harian) {
                // Hitung uang makan kasir
                $uang_makan_kasir = 0;
                $kasir_info = $this->User_model->get_by_id($kasir_hari_id);
                if ($kasir_info && $kasir_info->tipe_kasir) {
                    $tipe_kasir_hari = $kasir_info->tipe_kasir;
                    $aturan = $this->Aturan_uang_makan_kasir_model->get_by_tipe($tipe_kasir_hari);
                    if ($aturan) {
                        $uang_makan_kasir = (int)$aturan->uang_makan;
                    }
                } else {
                    // default bulanan if not set
                    $tipe_kasir_hari = 'bulanan';
                    $aturan = $this->Aturan_uang_makan_kasir_model->get_by_tipe('bulanan');
                    if ($aturan) {
                        $uang_makan_kasir = (int)$aturan->uang_makan;
                    }
                }
                
                $rekap_harian['uang_makan_kasir'] = $uang_makan_kasir;
                // Potong saldo akhir dengan uang makan kasir
                $rekap_harian['saldo'] = $rekap_harian['saldo'] - $uang_makan_kasir;
            }
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
                'summary_periode' => $summary_periode,
                'kasir_list' => $this->User_model->get_all_kasir(),
                // data buat kalkulator saldo
                'kasir_hari_id' => $kasir_hari_id,
                'tanggal_hari' => $tanggal_hari,
                'rekap_harian' => $rekap_harian,
                'tipe_kasir_hari' => $tipe_kasir_hari
            ],
            'bottom_nav' => $this->admin_bottom_nav('more')
        ];

        $this->load->view('layouts/mobile', $data);
    }

    public function simpan()
    {
        $tanggal = $this->input->post('tanggal', TRUE);
        $kasir_id = $this->input->post('kasir_id', TRUE);
        $uang_makan = (int)$this->input->post('uang_makan');
        $jumlah_tambahan = (int)$this->input->post('jumlah', TRUE);
        $catatan = $this->input->post('catatan', TRUE);

        // Validasi jumlah bisa 0 (karena bisa jadi dia hanya nerima uang makan saja)
        if (!$tanggal || !$kasir_id || $jumlah_tambahan === '') {
            $this->session->set_flashdata('error', 'Tanggal, kasir, dan gaji tambahan wajib diisi.');
            redirect('admin/gaji_kasir');
        }

        // Check duplicate payment
        $existing = $this->Gaji_kasir_model->check_existing($kasir_id, $tanggal);
        if ($existing) {
            $this->session->set_flashdata('error', 'Kasir ini sudah digaji pada tanggal tersebut.');
            redirect('admin/gaji_kasir');
        }

        // Server side validation for max bonus
        $rekap_harian = $this->Transaksi_model->get_rekap_kasir_harian($kasir_id, $tanggal);
        if ($rekap_harian) {
            $uang_makan_kasir = 0;
            $kasir_info = $this->User_model->get_by_id($kasir_id);
            if ($kasir_info && $kasir_info->tipe_kasir) {
                $aturan = $this->Aturan_uang_makan_kasir_model->get_by_tipe($kasir_info->tipe_kasir);
                if ($aturan) $uang_makan_kasir = (int)$aturan->uang_makan;
            } else {
                $aturan = $this->Aturan_uang_makan_kasir_model->get_by_tipe('bulanan');
                if ($aturan) $uang_makan_kasir = (int)$aturan->uang_makan;
            }
            $saldo_maksimal = $rekap_harian['saldo'] - $uang_makan_kasir;
            if ($jumlah_tambahan > $saldo_maksimal) {
                $this->session->set_flashdata('error', 'Gaji Tambahan tidak boleh lebih dari Sisa Laba (Rp ' . number_format($saldo_maksimal, 0, ',', '.') . ').');
                redirect('admin/gaji_kasir');
            }
        }

        $jumlah_total = $uang_makan + $jumlah_tambahan;

        $data = [
            'tanggal' => $tanggal,
            'kasir_id' => $kasir_id,
            'uang_makan' => $uang_makan,
            'jumlah' => $jumlah_total,
            'catatan' => $catatan
        ];

        if ($this->Gaji_kasir_model->insert($data)) {
            $this->session->set_flashdata('success', 'Gaji kasir berhasil disimpan.');
        }
        else {
            $this->session->set_flashdata('error', 'Gagal menyimpan gaji kasir.');
        }

        redirect('admin/gaji_kasir');
    }

    public function hapus($id)
    {
        $this->Gaji_kasir_model->delete($id);
        $this->session->set_flashdata('success', 'Data gaji berhasil dihapus.');
        redirect('admin/gaji_kasir');
    }

    public function kirim_slip_periode()
    {
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        $kasir_id = $this->input->post('kasir_id');

        if (!$tanggal_mulai || !$tanggal_selesai || !$kasir_id) {
            echo json_encode(['status' => false, 'message' => 'Parameter tidak lengkap']);
            return;
        }

        $kasir = $this->User_model->get_by_id($kasir_id);
        if (!$kasir || empty($kasir->no_hp)) {
            echo json_encode(['status' => false, 'message' => 'Kasir tidak ditemukan atau nomor HP kosong']);
            return;
        }

        $summary = $this->Gaji_kasir_model->get_summary_by_periode($tanggal_mulai, $tanggal_selesai, $kasir_id);
        if (!$summary || $summary->total_semua == 0) {
            echo json_encode(['status' => false, 'message' => 'Tidak ada data gaji pada periode ini']);
            return;
        }

        $total_uang_makan = (int)$summary->total_uang_makan;
        $total_semua = (int)$summary->total_semua;
        $total_gaji_pokok = $total_semua - $total_uang_makan;

        $message = "*SLIP GAJI KASIR - ALVINTO POS*\n\n";
        $message .= "Kepada: *{$kasir->nama}*\n";
        $message .= "Periode: " . date('d/m/Y', strtotime($tanggal_mulai)) . " - " . date('d/m/Y', strtotime($tanggal_selesai)) . "\n\n";
        
        $message .= "Uang Makan: Rp " . number_format($total_uang_makan, 0, ',', '.') . "\n";
        $message .= "Gaji Pokok/Bonus: Rp " . number_format($total_gaji_pokok, 0, ',', '.') . "\n";
        $message .= "--------------------------------\n";
        $message .= "Jumlah Diterima: *Rp " . number_format($total_semua, 0, ',', '.') . "*\n";
        
        $message .= "\n_Terima kasih atas kerja keras Anda!_ 🙏";

        $res = send_wa($kasir->no_hp, $message);
        if ($res['status']) {
            echo json_encode(['status' => true, 'message' => 'Slip gaji periode berhasil dikirim']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal mengirim WA: ' . $res['message']]);
        }
    }
}

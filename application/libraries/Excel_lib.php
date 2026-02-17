<?php
defined('BASEPATH') or exit('No direct script access allowed');

// matikan sementara E_DEPRECATED utk PHPExcel
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// load PHPExcel utama
require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

class Excel_lib
{

    public function export_laporan_absensi($report, $bulan, $tahun)
    {
        // buat objek baru
        $excel = new PHPExcel();
        $excel->getProperties()
            ->setCreator('Absensi Kantor')
            ->setTitle("Laporan Absensi $bulan/$tahun");

        $sheet = $excel->setActiveSheetIndex(0);

        // Judul
        $sheet->setCellValue('A1', "Laporan Absensi Bulan $bulan / $tahun");
        $sheet->mergeCells('A1:J1');

        // Header di baris 3
        $sheet->setCellValue('A3', 'Tanggal');
        $sheet->setCellValue('B3', 'Kode Pegawai');
        $sheet->setCellValue('C3', 'Nama');
        $sheet->setCellValue('D3', 'Lokasi');
        $sheet->setCellValue('E3', 'Jam Masuk');
        $sheet->setCellValue('F3', 'Status Masuk');
        $sheet->setCellValue('G3', 'Jam Pulang');
        $sheet->setCellValue('H3', 'Status Pulang');
        $sheet->setCellValue('I3', 'Status Harian');
        $sheet->setCellValue('J3', 'Total Jam');

        // Isi data mulai baris 4
        $rowNum = 4;
        foreach ($report as $row) {
            $sheet->setCellValue('A' . $rowNum, $row->tanggal);
            $sheet->setCellValue('B' . $rowNum, $row->kode_pegawai);
            $sheet->setCellValue('C' . $rowNum, $row->nama_lengkap);
            $sheet->setCellValue('D' . $rowNum, $row->nama_lokasi);
            $sheet->setCellValue('E' . $rowNum, $row->jam_masuk ? date('H:i', strtotime($row->jam_masuk)) : '');
            $sheet->setCellValue('F' . $rowNum, $row->status_masuk);
            $sheet->setCellValue('G' . $rowNum, $row->jam_pulang ? date('H:i', strtotime($row->jam_pulang)) : '');
            $sheet->setCellValue('H' . $rowNum, $row->status_pulang);
            $sheet->setCellValue('I' . $rowNum, $row->status_harian);
            $sheet->setCellValue('J' . $rowNum, $row->total_jam_kerja);
            $rowNum++;
        }

        // Biar kolom auto lebar
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama sheet
        $sheet->setTitle('Laporan Absensi');

        // Output ke browser sebagai .xlsx beneran
        $filename = "laporan_absensi_{$tahun}_{$bulan}.xlsx";

        // bersihkan output buffer kalau ada
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }

    public function export_laporan_transaksi($laporan, $periode_str)
    {
        // buat objek baru
        $excel = new PHPExcel();
        $excel->getProperties()
            ->setCreator('POS Alvinto')
            ->setTitle("Laporan Transaksi $periode_str");

        $sheet = $excel->setActiveSheetIndex(0);

        // Judul
        $sheet->setCellValue('A1', "Laporan Transaksi Periode $periode_str");
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Header di baris 3
        $headers = [
            'A' => 'No',
            'B' => 'Tanggal',
            'C' => 'Kasir',
            'D' => 'Karyawan',
            'E' => 'Jenis Pangkas',
            'F' => 'Metode Pembayaran',
            'G' => 'Harga'
        ];

        foreach ($headers as $col => $text) {
            $sheet->setCellValue($col . '3', $text);
            $sheet->getStyle($col . '3')->getFont()->setBold(true);
            $sheet->getStyle($col . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

        // Isi data mulai baris 4
        $rowNum = 4;
        $no = 1;
        $total_omzet = 0;

        foreach ($laporan as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, date('d/m/Y H:i', strtotime($row->tanggal)));
            $sheet->setCellValue('C' . $rowNum, $row->nama_kasir);
            $sheet->setCellValue('D' . $rowNum, $row->nama_karyawan);
            $sheet->setCellValue('E' . $rowNum, $row->jenis_pangkas);
            $sheet->setCellValue('F' . $rowNum, $row->metode_bayar);
            $sheet->setCellValue('G' . $rowNum, $row->harga);

            // Format Harga
            $sheet->getStyle('G' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');

            // Border per baris
            $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            // Alignment center untuk No dan Tanggal
            $sheet->getStyle('A' . $rowNum . ':B' . $rowNum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $total_omzet += $row->harga;
            $rowNum++;
        }

        // Baris Total
        $sheet->setCellValue('A' . $rowNum, 'TOTAL');
        $sheet->mergeCells('A' . $rowNum . ':F' . $rowNum);
        $sheet->setCellValue('G' . $rowNum, $total_omzet);

        $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sheet->getStyle('G' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Biar kolom auto lebar
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama sheet
        $sheet->setTitle('Laporan Transaksi');

        // Output ke browser sebagai .xlsx beneran
        $filename = "Laporan_Transaksi_" . date('YmdHis') . ".xlsx";

        // bersihkan output buffer kalau ada
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}

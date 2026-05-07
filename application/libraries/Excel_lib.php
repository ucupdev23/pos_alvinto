<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* |-------------------------------------------------------------------------- | Excel_lib | PHPExcel SAFE for PHP 8+ |-------------------------------------------------------------------------- */

// Matikan deprecated & strict (wajib utk PHPExcel)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// Load PHPExcel
require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

class Excel_lib
{
    /**
     * ================================
     * EXPORT LAPORAN TRANSAKSI
     * ================================
     */
    public function export_laporan_transaksi($laporan, $periode_str)
    {
        $excel = new PHPExcel();
        $excel->getProperties()
            ->setCreator('POS Alvinto')
            ->setTitle("Laporan Transaksi $periode_str");

        $sheet = $excel->setActiveSheetIndex(0);

        /*
         |--------------------------------------------------------------------------
         | JUDUL
         |--------------------------------------------------------------------------
         */
        $sheet->setCellValue('A1', "Laporan Transaksi Periode $periode_str");
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /*
         |--------------------------------------------------------------------------
         | HEADER
         |--------------------------------------------------------------------------
         */
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
            $sheet->setCellValueExplicit(
                $col . '3',
                $text,
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->getStyle($col . '3')->getFont()->setBold(true);
            $sheet->getStyle($col . '3')->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '3')->getBorders()
                ->getAllBorders()
                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

        /*
         |--------------------------------------------------------------------------
         | DATA
         |--------------------------------------------------------------------------
         */
        $rowNum = 4;
        $no = 1;
        $total_omzet = 0;

        foreach ($laporan as $row) {

            // No (STRING supaya PHPExcel aman)
            $sheet->setCellValueExplicit(
                'A' . $rowNum,
                (string)$no,
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            // Tanggal
            $tanggal = !empty($row->tanggal)
                ? date('d/m/Y H:i', strtotime($row->tanggal))
                : '';

            $sheet->setCellValueExplicit(
                'B' . $rowNum,
                $tanggal,
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            // String columns
            $sheet->setCellValueExplicit('C' . $rowNum, (string)(isset($row->nama_kasir) ? $row->nama_kasir : ''), PHPExcel_Cell_DataType::TYPE_STRING);            $sheet->setCellValueExplicit('D' . $rowNum, (string)(isset($row->nama_karyawan) ? $row->nama_karyawan : ''), PHPExcel_Cell_DataType::TYPE_STRING);            $sheet->setCellValueExplicit('E' . $rowNum, (string)(isset($row->jenis_pangkas) ? $row->jenis_pangkas : ''), PHPExcel_Cell_DataType::TYPE_STRING);            $sheet->setCellValueExplicit('F' . $rowNum, (string)(isset($row->metode_bayar) ? $row->metode_bayar : ''), PHPExcel_Cell_DataType::TYPE_STRING);

            // Harga (NUMERIC EXPLICIT)
            $harga = isset($row->harga) ? (int)$row->harga : 0;

            $sheet->setCellValueExplicit(
                'G' . $rowNum,
                $harga,
                PHPExcel_Cell_DataType::TYPE_NUMERIC
            );

            $sheet->getStyle('G' . $rowNum)
                ->getNumberFormat()
                ->setFormatCode('#,##0');

            // Border row
            $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            // Alignment
            $sheet->getStyle('A' . $rowNum . ':B' . $rowNum)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $total_omzet += $harga;
            $rowNum++;
            $no++;
        }

        /*
         |--------------------------------------------------------------------------
         | TOTAL
         |--------------------------------------------------------------------------
         */
        $sheet->mergeCells('A' . $rowNum . ':F' . $rowNum);
        $sheet->setCellValueExplicit(
            'A' . $rowNum,
            'TOTAL',
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'G' . $rowNum,
            (int)$total_omzet,
            PHPExcel_Cell_DataType::TYPE_NUMERIC
        );

        $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowNum . ':G' . $rowNum)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sheet->getStyle('G' . $rowNum)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle('A' . $rowNum)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        /*
         |--------------------------------------------------------------------------
         | AUTOSIZE
         |--------------------------------------------------------------------------
         */
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle('Laporan Transaksi');

        /*
         |--------------------------------------------------------------------------
         | OUTPUT
         |--------------------------------------------------------------------------
         */
        $filename = 'Laporan_Transaksi_' . date('YmdHis') . '.xlsx';

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

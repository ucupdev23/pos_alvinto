<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3, .header p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-table {
            width: 40%;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>LAPORAN TRANSAKSI</h3>
        <p>Periode: <?= date('d/m/Y', strtotime($tanggal_mulai)); ?> - <?= date('d/m/Y', strtotime($tanggal_selesai)); ?></p>
    </div>

    <?php if ($rekap): ?>
        <table class="summary-table">
            <tr>
                <td style="background-color: #f2f2f2;"><strong>Total Omzet</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($rekap->total_omzet ?: 0, 0, ',', '.'); ?></strong></td>
            </tr>
            <tr>
                <td style="background-color: #f2f2f2;"><strong>Total Potongan</strong></td>
                <td class="text-end"><?= $rekap->total_potong ?: 0; ?></td>
            </tr>
        </table>
    <?php
endif; ?>

    <!-- Detail Transaksi -->
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Kasir</th>
                <th>Karyawan</th>
                <th>Jenis</th>
                <th>Metode</th>
                <th width="80">Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
$no = 1;
foreach ($laporan as $t):
?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= date('d/m/y H:i', strtotime($t->tanggal)); ?></td>
                    <td><?= $t->nama_kasir; ?></td>
                    <td><?= $t->nama_karyawan; ?></td>
                    <td><?= $t->jenis_pangkas; ?></td>
                    <td><?= $t->metode_bayar; ?></td>
                    <td class="text-end">Rp <?= number_format($t->harga, 0, ',', '.'); ?></td>
                </tr>
            <?php
endforeach; ?>
            
            <?php if (empty($laporan)): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php
endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right; font-size: 10px;">
        Dicetak pada: <?= date('d/m/Y H:i:s'); ?>
    </div>

</body>
</html>

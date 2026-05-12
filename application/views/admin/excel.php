<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi.xls");
?>

<h3>Laporan Transaksi</h3>
<p>Periode: <?= date('d/m/Y', strtotime($tanggal_mulai)); ?> - <?= date('d/m/Y', strtotime($tanggal_selesai)); ?></p>

<table border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th style="background-color: #f2f2f2;">No</th>
            <th style="background-color: #f2f2f2;">Tanggal</th>
            <th style="background-color: #f2f2f2;">Kasir</th>
            <th style="background-color: #f2f2f2;">Kapster</th>
            <th style="background-color: #f2f2f2;">Jenis</th>
            <th style="background-color: #f2f2f2;">Metode</th>
            <th style="background-color: #f2f2f2;">Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $total_omzet = 0;
        foreach ($laporan as $row):
            $total_omzet += $row->harga;
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="text-align: center;"><?= date('d/m/Y H:i', strtotime($row->tanggal)); ?></td>
                <td><?= $row->nama_kasir; ?></td>
                <td><?= $row->nama_karyawan; ?></td>
                <td><?= $row->jenis_pangkas; ?></td>
                <td><?= $row->metode_bayar; ?></td>
                <td style="text-align: right;">Rp <?= number_format($row->harga, 0, ',', '.'); ?></td>
            </tr>
            <?php
        endforeach; ?>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; background-color: #f2f2f2;">TOTAL</td>
            <td style="text-align: right; font-weight: bold; background-color: #f2f2f2;">Rp
                <?= number_format($total_omzet, 0, ',', '.'); ?></td>
        </tr>
    </tbody>
</table>
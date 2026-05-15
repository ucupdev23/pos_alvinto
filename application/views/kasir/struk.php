<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 10px;
            font-size: 12px;
            color: #000;
            background: #fff;
        }
        .struk-container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .title {
            font-size: 26px; /* Diperbesar seperti h2/h3 */
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 14px; /* Sedikit diperbesar dari 11px */
            margin-bottom: 15px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 2px 0;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .footer-logo {
            width: 150px;
            margin: 20px auto; /* Jarak atas bawah logo diperbesar */
            display: block;
        }
        .footer-text {
            font-size: 11px;
            margin-top: 20px;
        }
        .wa-text {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 30px; /* Jarak bawah WA */
        }
        
        @media print {
            body { padding: 0; }
            .struk-container { width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body onload="window.print();">

<div class="struk-container">
    <div class="text-center">
        <br><br>
        <div class="title">ALVINTO HAIRCUT</div>
        <div class="subtitle">-- specialist men & kids --</div>
    </div>
    
    <table>
        <tr>
            <td class="text-left">Nama Barber</td>
            <td class="text-right"><?= $transaksi->nama_karyawan; ?></td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <table>
        <tr>
            <td class="text-left font-bold">Date</td>
            <td class="text-right font-bold"><?= date('d/m/Y', strtotime($transaksi->tanggal)); ?></td>
        </tr>
        <tr>
            <td class="text-left">Tarif <?= $transaksi->jenis_pangkas; ?></td>
            <td class="text-right">Rp.<?= number_format($transaksi->harga, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="text-left">Pembayaran</td>
            <td class="text-right"><?= $transaksi->metode_bayar; ?></td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <table>
        <?php if ($transaksi->metode_pembayaran_id == 1 && $bayar): ?>
        <tr>
            <td class="text-left">Bayar</td>
            <td class="text-right">Rp.<?= number_format($bayar, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="text-left">Kembalian</td>
            <td class="text-right">Rp.<?= number_format($kembalian, 0, ',', '.'); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td class="text-left">Nama Kasir</td>
            <td class="text-right"><?= $transaksi->nama_kasir; ?></td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <div class="text-center">
        <br>
        <div class="footer-text">TERIMA KASIH ATAS KUNJUNGAN ANDA</div>
        
        <img src="<?= base_url('assets/logo.png'); ?>" class="footer-logo" alt="Alvinto Logo">
        
        <div class="wa-text">
            WhatsApp :<br>
            (087770077254) - (087870708254)
        </div>
    </div>
</div>

</body>
</html>

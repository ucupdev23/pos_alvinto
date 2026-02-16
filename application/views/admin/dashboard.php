<?php
$today       = isset($today) ? $today : date('Y-m-d');
$rekap_hari  = isset($rekap_hari) ? $rekap_hari : ['total_omzet' => 0, 'total_potong' => 0];
$rekap_bulan = isset($rekap_bulan) ? $rekap_bulan : ['total_omzet' => 0, 'total_potong' => 0];
$top_hari    = isset($top_hari) ? $top_hari : [];
?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted" style="font-size: 11px;">Selamat datang,</div>
                        <div style="font-size: 14px; font-weight: 600;">
                            <?= $this->session->userdata('nama'); ?> 👋
                        </div>
                        <div class="text-muted" style="font-size: 11px;">
                            Tanggal <?= date('d M Y', strtotime($today)); ?>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-dark" style="font-size: 11px;">
                            Admin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Hari Ini & Bulan Ini -->
    <div class="col-12">
        <div class="row g-2">
            <div class="col-6">
                <div class="card card-app h-100">
                    <div class="card-body py-3">
                        <div class="text-muted mb-1" style="font-size: 11px;">Omzet Hari Ini</div>
                        <div style="font-size: 16px; font-weight: 700;">
                            Rp <?= number_format($rekap_hari['total_omzet'], 0, ',', '.'); ?>
                        </div>
                        <div class="text-muted mt-1" style="font-size: 11px;">
                            <?= $rekap_hari['total_potong']; ?> potongan
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-app h-100">
                    <div class="card-body py-3">
                        <div class="text-muted mb-1" style="font-size: 11px;">
                            Omzet Bulan Ini
                        </div>
                        <div style="font-size: 16px; font-weight: 700;">
                            Rp <?= number_format($rekap_bulan['total_omzet'], 0, ',', '.'); ?>
                        </div>
                        <div class="text-muted mt-1" style="font-size: 11px;">
                            <?= $rekap_bulan['total_potong']; ?> potongan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Karyawan Hari Ini -->
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <h6 class="mb-0">Top Karyawan Hari Ini</h6>
                    <span class="text-muted" style="font-size: 11px;">
                        <?= date('d M Y', strtotime($today)); ?>
                    </span>
                </div>

                <?php if (empty($top_hari)): ?>
                    <p class="text-muted mb-0" style="font-size: 12px;">
                        Belum ada transaksi hari ini.
                    </p>
                <?php else: ?>
                    <div class="list-group small">
                        <?php foreach ($top_hari as $idx => $t): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= ($idx + 1) . '. ' . $t->nama_karyawan; ?></strong><br>
                                    <span class="text-muted" style="font-size: 11px;">
                                        <?= $t->total_potong; ?> potongan
                                    </span>
                                </div>
                                <div class="text-end">
                                    <div style="font-size: 12px;">
                                        Rp <?= number_format($t->total_omzet, 0, ',', '.'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Akses Cepat -->
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-2">Akses Cepat</h6>
                <div class="row g-2">
                    <div class="col-6">
                        <a href="<?= site_url('admin/master'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-grid-3x3-gap me-1"></i> Master Data
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= site_url('admin/laporan'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-clipboard-data me-1"></i> Laporan
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="<?= site_url('admin/gaji_kasir'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-cash-coin me-1"></i> Gaji Kasir
                        </a>
                    </div>
                    <!-- <div class="col-6">
                        <a href="<?= site_url('admin/more'); ?>" class="btn btn-outline-secondary w-100 btn-app">
                            <i class="bi bi-three-dots me-1"></i> Lainnya
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

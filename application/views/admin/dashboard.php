<?php
$today = isset($today) ? $today : date('Y-m-d');
$rekap_hari = isset($rekap_hari) ? $rekap_hari : ['total_omzet' => 0, 'total_potong' => 0];
$rekap_bulan = isset($rekap_bulan) ? $rekap_bulan : ['total_omzet' => 0, 'total_potong' => 0];
$rekap_bulan = isset($rekap_bulan) ? $rekap_bulan : ['total_omzet' => 0, 'total_potong' => 0];
$top_hari = isset($top_hari) ? $top_hari : [];
$recent_transaksi = isset($recent_transaksi) ? $recent_transaksi : [];
$chart_mingguan = isset($chart_mingguan) ? $chart_mingguan : [];

// Pindahkan data chart ke format JS
// Pindahkan data chart ke format JS
$chart_labels = [];
$chart_omzet = [];
$chart_profit = [];
foreach ($chart_mingguan as $c) {
    $chart_labels[] = $c['tanggal'];
    $chart_omzet[] = $c['omzet'];
    $chart_profit[] = $c['keuntungan'];
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        <div class="text-muted mb-1" style="font-size: 11px;">Hari Ini</div>
                        <div style="font-size: 16px; font-weight: 700;">
                            Rp <?= number_format($rekap_hari['total_omzet'], 0, ',', '.'); ?>
                        </div>
                        <div class="text-success mt-1" style="font-size: 11px; font-weight: 600;">
                            Untung: Rp <?= number_format($rekap_hari['profit'], 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-app h-100">
                    <div class="card-body py-3">
                        <div class="text-muted mb-1" style="font-size: 11px;">
                            Bulan Ini
                        </div>
                        <div style="font-size: 16px; font-weight: 700;">
                            Rp <?= number_format($rekap_bulan['total_omzet'], 0, ',', '.'); ?>
                        </div>
                        <div class="text-success mt-1" style="font-size: 11px; font-weight: 600;">
                            Untung: Rp <?= number_format($rekap_bulan['profit'], 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    <!-- Grafik Omzet -->
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-3" style="font-size: 14px;">Grafik Pendapatan 7 Hari</h6>
                <canvas id="revenueChart" style="height: 200px; width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Karyawan Split -->
    <div class="col-12">
        <div class="row g-2">
            <!-- Hari Ini -->
            <div class="col-6">
                <div class="card card-app mb-2 h-100">
                    <div class="card-body">
                        <h6 class="mb-2" style="font-size: 12px;">Top Hari Ini</h6>
                        <?php if (empty($top_hari)): ?>
                            <p class="text-muted mb-0" style="font-size: 11px;">Kosong.</p>
                        <?php
else: ?>
                            <div class="list-group small">
                                <?php foreach ($top_hari as $idx => $t): ?>
                                    <div class="mb-2">
                                        <div style="font-size: 11px; font-weight: 600;"><?=($idx + 1) . '. ' . $t->nama_karyawan; ?></div>
                                        <div class="d-flex justify-content-between text-muted" style="font-size: 10px;">
                                            <span><?= $t->total_potong; ?> potong</span>
                                            <span>Rp <?= number_format($t->total_omzet, 0, ',', '.'); ?></span>
                                        </div>
                                    </div>
                                <?php
    endforeach; ?>
                            </div>
                        <?php
endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Bulan Ini -->
             <div class="col-6">
                <div class="card card-app mb-2 h-100">
                    <div class="card-body">
                        <h6 class="mb-2" style="font-size: 12px;">Top Bulan Ini</h6>
                        <?php if (empty($top_bulan)): ?>
                            <p class="text-muted mb-0" style="font-size: 11px;">Kosong.</p>
                        <?php
else: ?>
                             <div class="list-group small">
                                <?php foreach ($top_bulan as $idx => $t): ?>
                                    <div class="mb-2">
                                        <div style="font-size: 11px; font-weight: 600;"><?=($idx + 1) . '. ' . $t->nama_karyawan; ?></div>
                                        <div class="d-flex justify-content-between text-muted" style="font-size: 10px;">
                                            <span><?= $t->total_potong; ?> potong</span>
                                            <span>Rp <?= number_format($t->total_omzet, 0, ',', '.'); ?></span>
                                        </div>
                                    </div>
                                <?php
    endforeach; ?>
                            </div>
                        <?php
endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terakhir -->
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="mb-0">Transaksi Terakhir</h6>
                    <a href="<?= site_url('admin/laporan'); ?>" class="text-decoration-none" style="font-size: 11px;">Lihat Semua</a>
                </div>
                
                <?php if (empty($recent_transaksi)): ?>
                    <p class="text-muted mb-0" style="font-size: 12px;">Belum ada transaksi.</p>
                <?php
else: ?>
                    <div class="list-group small">
                        <?php foreach ($recent_transaksi as $rt): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <div style="font-weight: 600;"><?= $rt->jenis_pangkas; ?></div>
                                    <div class="text-muted" style="font-size: 10px;">
                                        <?= date('d/m H:i', strtotime($rt->tanggal . ' ' . (isset($rt->created_at) ? date('H:i', strtotime($rt->created_at)) : ''))); ?> • <?= $rt->nama_karyawan; ?>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div style="font-size: 12px; font-weight: 600;">
                                        Rp <?= number_format($rt->harga, 0, ',', '.'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
    endforeach; ?>
                    </div>
                <?php
endif; ?>
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


<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels); ?>,
            datasets: [
                {
                    label: 'Omzet',
                    data: <?= json_encode($chart_omzet); ?>,
                    borderColor: '#6c757d', // Grey for Omzet
                    backgroundColor: 'rgba(108, 117, 125, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: false,
                    pointRadius: 2
                },
                {
                    label: 'Keuntungan',
                    data: <?= json_encode($chart_profit); ?>,
                    borderColor: '#198754', // Green for Profit
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 4],
                        color: '#f0f0f0'
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            if (value >= 1000) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
</script>

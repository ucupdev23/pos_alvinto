<div class="row g-2">
    <div class="col-12">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php
endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2 mb-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php
endif; ?>

        <!-- KALKULATOR SALDO HARIAN KASIR -->
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-2">Kalkulator Saldo Harian Kasir</h6>
                <form method="get" action="<?= site_url('admin/gaji_kasir'); ?>" class="small mb-2">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small">Kasir</label>
                            <select name="kasir_hari_id" class="form-select form-select-sm" required>
                                <option value="">- Pilih Kasir -</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_hari_id == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Tanggal</label>
                            <input type="date" name="tanggal_hari" class="form-control form-control-sm"
                                   value="<?= $tanggal_hari; ?>" required>
                        </div>
                        <!-- Supaya filter list gaji tidak hilang, kirim juga sebagai hidden -->
                        <input type="hidden" name="tanggal_mulai" value="<?= $tanggal_mulai; ?>">
                        <input type="hidden" name="tanggal_selesai" value="<?= $tanggal_selesai; ?>">
                        <input type="hidden" name="kasir_id" value="<?= $kasir_id_filter; ?>">
                        <div class="col-12 d-grid mt-1">
                            <button type="submit" class="btn btn-dark btn-sm btn-app">
                                <i class="bi bi-calculator me-1"></i> Hitung Saldo
                            </button>
                        </div>
                    </div>
                </form>

                <?php if ($kasir_hari_id && $rekap_harian): ?>
                    <hr>
                    <p class="mb-1" style="font-size: 12px;">
                        <strong>Ringkasan Kasir</strong><br>
                        Kasir:
                        <?php
    $nama_kasir = '';
    foreach ($kasir_list as $k) {
        if ($k->id == $kasir_hari_id) {
            $nama_kasir = $k->nama;
            break;
        }
    }
    echo $nama_kasir;
?>
                        <br>
                        Tanggal: <?= date('d/m/Y', strtotime($tanggal_hari)); ?>
                    </p>

                    <table class="table table-sm mb-2" style="font-size: 12px;">
                        <tr>
                            <td>Total Omzet</td>
                            <td class="text-end">
                                Rp <?= number_format($rekap_harian['total_omzet'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Total Gaji Karyawan</td>
                            <td class="text-end">
                                Rp <?= number_format($rekap_harian['total_gaji_karyawan'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Sisa Dana</th>
                            <th class="text-end">
                                Rp <?= number_format($rekap_harian['saldo'], 0, ',', '.'); ?>
                            </th>
                        </tr>
                    </table>

                    <?php if (!empty($rekap_harian['per_karyawan'])): ?>
                        <p class="text-muted mb-1" style="font-size: 11px;">Rincian per karyawan:</p>
                        <table class="table table-sm mb-2" style="font-size: 11px;">
                            <thead class="table-light">
                            <tr>
                                <th>Karyawan</th>
                                <th class="text-end">Omzet</th>
                                <th class="text-end">Gaji</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($rekap_harian['per_karyawan'] as $rk): ?>
                                <tr>
                                    <td><?= $rk['nama_karyawan']; ?></td>
                                    <td class="text-end">Rp <?= number_format($rk['omzet'], 0, ',', '.'); ?></td>
                                    <td class="text-end">Rp <?= number_format($rk['total_gaji'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php
        endforeach; ?>
                            </tbody>
                        </table>
                    <?php
    endif; ?>

                    <p class="text-muted mb-0" style="font-size: 11px;">
                        Owner bisa pakai angka <strong>Sisa Dana</strong> sebagai acuan untuk menentukan gaji kasir di tanggal tersebut.
                    </p>
                <?php
elseif ($kasir_hari_id && !$rekap_harian): ?>
                    <p class="text-muted mb-0" style="font-size: 11px;">
                        Tidak ada transaksi untuk kasir dan tanggal yang dipilih.
                    </p>
                <?php
endif; ?>
            </div>
        </div>

        <!-- FORM INPUT GAJI -->
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-2">Input Gaji Kasir</h6>
                <form method="post" action="<?= site_url('admin/gaji_kasir/simpan'); ?>" class="small">
                    <div class="mb-2">
                        <label class="form-label small">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm"
                               value="<?= $tanggal_hari; ?>" required readonly style="background-color: #f8f9fa;">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Kasir</label>
                        <?php if ($kasir_hari_id && $rekap_harian): ?>
                            <?php
    $nama_kasir_selected = '';
    foreach ($kasir_list as $k) {
        if ($k->id == $kasir_hari_id) {
            $nama_kasir_selected = $k->nama;
            break;
        }
    }
?>
                            <input type="text" class="form-control form-control-sm" value="<?= $nama_kasir_selected; ?>" readonly>
                            <input type="hidden" name="kasir_id" value="<?= $kasir_hari_id; ?>">
                            <small class="text-muted">Kasir otomatis dari kalkulator saldo harian</small>
                        <?php
else: ?>
                            <input type="text" class="form-control form-control-sm" value="Pilih kasir di kalkulator saldo harian dulu" readonly style="background-color: #f8f9fa;">
                            <small class="text-danger">Harus hitung saldo harian dahulu</small>
                        <?php
endif; ?>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Jumlah Gaji (Rp)</label>
                        <input type="number" name="jumlah" class="form-control form-control-sm"
                               min="0"
                               placeholder="<?= $rekap_harian ? 'Sisa dana: Rp ' . number_format($rekap_harian['saldo'], 0, ',', '.') : ''; ?>"
                               required>
                        <?php if ($rekap_harian): ?>
                            <div class="alert alert-warning py-2 mt-2" role="alert">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Sisa saldo tersedia: <strong>Rp <?= number_format($rekap_harian['saldo'], 0, ',', '.'); ?></strong>
                            </div>
                        <?php
endif; ?>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Catatan (opsional)</label>
                        <input type="text" name="catatan" class="form-control form-control-sm"
                               placeholder="Misal: gaji shift pagi">
                    </div>
                    <button type="submit" class="btn btn-dark btn-sm w-100 btn-app mt-1" 
                        <?=(!$kasir_hari_id || !$rekap_harian) ? 'disabled' : ''; ?>>
                        <i class="bi bi-save me-1"></i> Simpan Gaji Kasir
                    </button>
                </form>
            </div>
        </div>

        <!-- FILTER LAPORAN GAJI -->
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-2">Laporan Gaji Kasir</h6>
                <form method="get" action="<?= site_url('admin/gaji_kasir'); ?>" class="small">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small">Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm"
                                   value="<?= $tanggal_mulai; ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control form-control-sm"
                                   value="<?= $tanggal_selesai; ?>">
                        </div>
                        <div class="col-9">
                            <label class="form-label small">Kasir</label>
                            <select name="kasir_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_id_filter == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                <?php
endforeach; ?>
                            </select>
                        </div>
                        <div class="col-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-dark btn-sm w-100 btn-app mt-1">
                                Go
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- LIST GAJI -->
        <div class="card card-app">
            <div class="card-body p-0">
                <?php if (empty($gaji_list)): ?>
                    <p class="text-center text-muted py-3 mb-0" style="font-size: 12px;">
                        Belum ada data gaji kasir pada periode ini.
                    </p>
                <?php
else: ?>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm mb-0" style="font-size: 11px;">
                            <thead class="table-light">
                            <tr>
                                <th>Tgl</th>
                                <th>Kasir</th>
                                <th class="text-end">Jumlah</th>
                                <th>Catatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($gaji_list as $g): ?>
                                <tr>
                                    <td><?= date('d/m', strtotime($g->tanggal)); ?></td>
                                    <td><?= $g->nama_kasir; ?></td>
                                    <td class="text-end">Rp <?= number_format($g->jumlah, 0, ',', '.'); ?></td>
                                    <td><?= $g->catatan; ?></td>
                                    <td class="text-center">
                                        <button onclick="resendSlip(<?= $g->id; ?>)" 
                                            class="btn btn-sm btn-outline-success" 
                                            style="font-size: 10px; padding: 2px 6px;"
                                            title="Kirim ulang slip ke WA">
                                            <i class="bi bi-whatsapp"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
    endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php
endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
function resendSlip(gajiId) {
    if (!confirm('Kirim ulang slip gaji ke WhatsApp?')) {
        return;
    }

    fetch('<?= site_url('admin/gaji_kasir/resend_slip/'); ?>' + gajiId)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                alert('✓ ' + data.message);
            } else {
                alert('✗ ' + data.message);
            }
        })
        .catch(error => {
            alert('✗ Terjadi kesalahan saat mengirim slip');
            console.error('Error:', error);
        });
}
</script>

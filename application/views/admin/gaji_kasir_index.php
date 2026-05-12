<div class="row g-2">
    <div class="col-12">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2 mb-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- BAGIAN 1: INPUT GAJI BARU -->
        <div class="card card-app mb-3" style="border-top: 3px solid #333;">
            <div class="card-body">
                <h6 class="mb-3 fw-bold"><i class="bi bi-wallet2 me-2"></i>Buat Gaji Kasir Baru</h6>
                
                <!-- Form Pilih Kasir & Tanggal -->
                <form method="get" action="<?= site_url('admin/gaji_kasir'); ?>" class="small mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-muted mb-1" style="font-size: 11px;">Pilih Kasir</label>
                            <select name="kasir_hari_id" class="form-select form-select-sm" required>
                                <option value="">- Pilih Kasir -</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_hari_id == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted mb-1" style="font-size: 11px;">Tanggal</label>
                            <input type="date" name="tanggal_hari" class="form-control form-control-sm"
                                   value="<?= $tanggal_hari; ?>" required>
                        </div>
                        <!-- Supaya filter list gaji tidak hilang, kirim juga sebagai hidden -->
                        <input type="hidden" name="tanggal_mulai" value="<?= $tanggal_mulai; ?>">
                        <input type="hidden" name="tanggal_selesai" value="<?= $tanggal_selesai; ?>">
                        <input type="hidden" name="kasir_id" value="<?= $kasir_id_filter; ?>">
                        
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-outline-dark btn-sm w-100">
                                <i class="bi bi-search me-1"></i> Cek Saldo Laba
                            </button>
                        </div>
                    </div>
                </form>

                <?php if ($kasir_hari_id && $rekap_harian): ?>
                    <!-- Kuitansi Ringkasan Saldo -->
                    <div class="bg-light p-3 rounded mb-3" style="border: 1px dashed #ccc;">
                        <div class="text-center mb-2">
                            <span class="badge bg-dark mb-1">RINGKASAN PENDAPATAN</span><br>
                            <?php
                                $nama_kasir = '';
                                foreach ($kasir_list as $k) {
                                    if ($k->id == $kasir_hari_id) { $nama_kasir = $k->nama; break; }
                                }
                            ?>
                            <strong style="font-size: 14px;"><?= $nama_kasir; ?></strong><br>
                            <span class="text-muted" style="font-size: 11px;"><?= date('d F Y', strtotime($tanggal_hari)); ?></span>
                        </div>
                        
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Total Omzet</span>
                            <span>Rp <?= number_format($rekap_harian['total_omzet'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Gaji Kapster (50%)</span>
                            <span class="text-danger">- Rp <?= number_format($rekap_harian['total_gaji_karyawan'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2 pb-2" style="border-bottom: 1px dashed #ccc;">
                            <span class="text-muted">Uang Makan Kasir (<?= ucfirst($tipe_kasir_hari ?? 'Bulanan'); ?>)</span>
                            <span class="text-danger">- Rp <?= number_format($rekap_harian['uang_makan_kasir'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong style="font-size: 13px;">SISA LABA BERSIH</strong>
                            <strong style="font-size: 14px; color: #198754;">Rp <?= number_format($rekap_harian['saldo'], 0, ',', '.'); ?></strong>
                        </div>
                    </div>

                    <!-- Form Simpan Gaji -->
                    <form method="post" action="<?= site_url('admin/gaji_kasir/simpan'); ?>" class="small">
                        <input type="hidden" name="tanggal" value="<?= $tanggal_hari; ?>">
                        <input type="hidden" name="kasir_id" value="<?= $kasir_hari_id; ?>">
                        <input type="hidden" name="uang_makan" value="<?= $rekap_harian['uang_makan_kasir']; ?>">
                        <input type="hidden" id="max_bonus" value="<?= $rekap_harian['saldo']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold mb-1">Beri Gaji Tambahan/Bonus (Rp)</label>
                            <input type="text" id="jumlah_display" class="form-control form-control-lg text-center fw-bold" inputmode="numeric"
                                   placeholder="0" style="font-size: 20px; color: #0d6efd;" required autocomplete="off">
                            <input type="hidden" name="jumlah" id="jumlah_real">
                            <div class="text-center mt-1">
                                <small class="text-muted">Maksimal: Rp <?= number_format($rekap_harian['saldo'], 0, ',', '.'); ?></small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">Catatan (opsional)</label>
                            <input type="text" name="catatan" class="form-control form-control-sm" placeholder="Misal: Gaji shift pagi">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 8px;">
                            <i class="bi bi-save me-1"></i> SIMPAN GAJI KASIR
                        </button>
                    </form>

                <?php elseif ($kasir_hari_id && !$rekap_harian): ?>
                    <div class="alert alert-secondary text-center small py-3 mb-0">
                        <i class="bi bi-info-circle mb-2" style="font-size: 20px; display: block;"></i>
                        Tidak ada transaksi untuk kasir dan tanggal yang dipilih.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- BAGIAN 2: RIWAYAT & LAPORAN -->
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-3 fw-bold"><i class="bi bi-clock-history me-2"></i>Riwayat & Slip Gaji</h6>
                <form method="get" action="<?= site_url('admin/gaji_kasir'); ?>" class="small bg-light p-2 rounded mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-muted mb-1" style="font-size: 10px;">Dari Tgl</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm border-0"
                                   value="<?= $tanggal_mulai; ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted mb-1" style="font-size: 10px;">Sampai Tgl</label>
                            <input type="date" name="tanggal_selesai" class="form-control form-control-sm border-0"
                                   value="<?= $tanggal_selesai; ?>">
                        </div>
                        <div class="col-8">
                            <select name="kasir_id" class="form-select form-select-sm border-0">
                                <option value="">Semua Kasir</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_id_filter == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-dark btn-sm w-100 h-100">Filter</button>
                        </div>
                    </div>
                </form>

                <?php if (!empty($gaji_list) && $kasir_id_filter && isset($summary_periode)): ?>
                    <div class="bg-light p-3 rounded mb-3" style="border: 1px dashed #ccc;">
                        <div class="text-center mb-2">
                            <span class="badge bg-dark mb-1">RINGKASAN PERIODE</span><br>
                            <span class="text-muted" style="font-size: 11px;"><?= date('d M Y', strtotime($tanggal_mulai)); ?> - <?= date('d M Y', strtotime($tanggal_selesai)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Total Uang Makan</span>
                            <span>Rp <?= number_format($summary_periode->total_uang_makan, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2 pb-2" style="border-bottom: 1px dashed #ccc;">
                            <span class="text-muted">Total Gaji Tambahan</span>
                            <span>Rp <?= number_format($summary_periode->total_semua - $summary_periode->total_uang_makan, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <strong style="font-size: 13px;">TOTAL DITERIMA</strong>
                            <strong style="font-size: 14px; color: #198754;">Rp <?= number_format($summary_periode->total_semua, 0, ',', '.'); ?></strong>
                        </div>
                        <button type="button" onclick="kirimSlipPeriode()" class="btn btn-success btn-sm w-100 fw-bold" style="border-radius: 6px;">
                            <i class="bi bi-whatsapp me-2"></i> Kirim Slip Periode ke WA
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (empty($gaji_list)): ?>
                    <p class="text-center text-muted py-4 mb-0" style="font-size: 12px;">
                        Belum ada data riwayat gaji kasir.
                    </p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size: 11px;">
                            <thead class="table-light">
                            <tr>
                                <th class="text-muted">Tgl</th>
                                <th class="text-muted">Kasir</th>
                                <th class="text-end text-muted">U. Makan</th>
                                <th class="text-end text-muted">Bonus</th>
                                <th class="text-end text-muted">Total</th>
                                <th class="text-center text-muted"><i class="bi bi-gear"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($gaji_list as $g): 
                                $bonus = $g->jumlah - $g->uang_makan;
                            ?>
                                <tr>
                                    <td class="align-middle fw-medium"><?= date('d/m', strtotime($g->tanggal)); ?></td>
                                    <td class="align-middle text-truncate" style="max-width: 80px;"><?= $g->nama_kasir; ?></td>
                                    <td class="text-end align-middle text-muted">
                                        <?= number_format($g->uang_makan, 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-end align-middle text-muted">
                                        <?= number_format($bonus, 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-end align-middle fw-bold text-success">
                                        <?= number_format($g->jumlah, 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button onclick="hapusGaji(<?= $g->id; ?>)" 
                                            class="btn btn-sm btn-outline-danger" 
                                            style="font-size: 10px; padding: 2px 6px;"
                                            title="Hapus riwayat gaji">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
function hapusGaji(gajiId) {
    if (!confirm('Hapus riwayat gaji ini? Saldo kasir akan ikut tersetel ulang jika diperlukan.')) {
        return;
    }
    window.location.href = '<?= site_url('admin/gaji_kasir/hapus/'); ?>' + gajiId;
}

function kirimSlipPeriode() {
    if (!confirm('Kirim rekap slip gaji periode ini ke WhatsApp kasir?')) {
        return;
    }

    const tglMulai = '<?= $tanggal_mulai; ?>';
    const tglSelesai = '<?= $tanggal_selesai; ?>';
    const kasirId = '<?= $kasir_id_filter; ?>';

    fetch('<?= site_url('admin/gaji_kasir/kirim_slip_periode'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `tanggal_mulai=${tglMulai}&tanggal_selesai=${tglSelesai}&kasir_id=${kasirId}`
    })
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

// Script Formatting Input Ribuan
document.addEventListener('DOMContentLoaded', function() {
    const inputDisplay = document.getElementById('jumlah_display');
    const inputReal = document.getElementById('jumlah_real');
    const maxBonus = parseInt(document.getElementById('max_bonus') ? document.getElementById('max_bonus').value : 0) || 0;
    const formGaji = inputDisplay ? inputDisplay.closest('form') : null;

    if (inputDisplay && inputReal) {
        inputDisplay.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            inputReal.value = val;
            
            if (val !== '') {
                this.value = parseInt(val).toLocaleString('id-ID');
            } else {
                this.value = '';
            }
        });

        if (formGaji) {
            formGaji.addEventListener('submit', function(e) {
                const realVal = parseInt(inputReal.value) || 0;
                if (realVal > maxBonus) {
                    e.preventDefault();
                    alert(`Gaji Tambahan/Bonus (Rp ${realVal.toLocaleString('id-ID')}) tidak boleh lebih dari Sisa Laba Bersih (Rp ${maxBonus.toLocaleString('id-ID')})!`);
                }
            });
        }
    }
});
</script>

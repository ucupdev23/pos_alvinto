<div class="row g-2">
    <div class="col-12">
        
        <!-- Back Button & Title -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-bold"><i class="bi bi-wallet2 me-1"></i> Slip Gaji Kapster</h6>
            <a href="<?= site_url('admin/master'); ?>" class="btn btn-outline-dark btn-sm btn-app py-1 px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Filter Card -->
        <div class="card card-app mb-2 shadow-sm">
            <div class="card-body">
                <form method="get" action="<?= site_url('admin/gaji_karyawan'); ?>">
                    <div class="mb-2">
                        <label class="form-label small">Kapster</label>
                        <select name="karyawan_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Kapster -</option>
                            <?php foreach ($karyawan as $k): ?>
                                <option value="<?= $k->id; ?>" <?= ($karyawan_id == $k->id ? 'selected' : ''); ?>>
                                    <?= $k->nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm"
                            value="<?= $tanggal ? $tanggal : date('Y-m-d'); ?>" required>
                    </div>

                    <div class="d-flex gap-1 mt-2">
                        <button type="submit" class="btn btn-dark w-100 btn-app">
                            <i class="bi bi-search me-1"></i> Tampilkan Slip
                        </button>
                        <a href="<?= site_url('admin/gaji_karyawan'); ?>" class="btn btn-outline-secondary btn-app">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rincian Slip Gaji -->
        <?php if ($karyawan_id && $tanggal): ?>
            <div class="card card-app shadow-sm">
                <div class="card-body">
                    <?php if ($slip): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <small class="text-muted">Kapster</small><br>
                                <strong><?= $slip['nama_karyawan']; ?></strong>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Tanggal</small><br>
                                <strong><?= date('d/m/Y', strtotime($slip['tanggal'])); ?></strong>
                            </div>
                        </div>

                        <hr class="my-2">

                        <table class="table table-sm mb-2" style="font-size: 12px;">
                            <tr>
                                <td>Total Omzet</td>
                                <td class="text-end">Rp <?= number_format($slip['total_omzet'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Upah (50%)</td>
                                <td class="text-end">Rp <?= number_format($slip['upah'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td>Uang Makan</td>
                                <td class="text-end">Rp <?= number_format($slip['uang_makan'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Total Gaji</th>
                                <th class="text-end">Rp <?= number_format($slip['total_gaji'], 0, ',', '.'); ?></th>
                            </tr>
                            <tr>
                                <td colspan="2"><hr class="m-0"></td>
                            </tr>
                            <tr class="text-success">
                                <th>Profit Bersih</th>
                                <th class="text-end">Rp <?= number_format($slip['total_omzet'] - $slip['total_gaji'], 0, ',', '.'); ?></th>
                            </tr>
                        </table>

                        <?php if (!empty($detail)): ?>
                            <p class="text-muted mb-1 mt-3" style="font-size: 11px;">Detail potongan hari ini:</p>
                            <div class="table-responsive">
                                <table class="table table-sm" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Metode</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($detail as $d): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $d->jenis_pangkas; ?></td>
                                                <td>
                                                    <?php 
                                                    $metode = strtolower($d->metode_bayar);
                                                    if (strpos($metode, 'qris') !== false): ?>
                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold" style="font-size: 10px; padding: 2px 6px;">QRIS</span>
                                                    <?php elseif (strpos($metode, 'tunai') !== false || strpos($metode, 'cash') !== false): ?>
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold" style="font-size: 10px; padding: 2px 6px;">Tunai</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fw-bold" style="font-size: 10px; padding: 2px 6px;"><?= $d->metode_bayar; ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?= $d->qty; ?></td>
                                                <td class="text-end">
                                                    Rp <?= number_format($d->total_harga, 0, ',', '.'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('admin/gaji_karyawan/kirim_wa'); ?>" method="post">
                            <input type="hidden" name="karyawan_id" value="<?= $karyawan_id; ?>">
                            <input type="hidden" name="tanggal" value="<?= $tanggal; ?>">
                            <button type="submit" class="btn btn-success w-100 btn-app mt-2">
                                <i class="bi bi-whatsapp me-1"></i> Kirim Slip ke WA Karyawan
                            </button>
                        </form>

                    <?php else: ?>
                        <p class="text-center text-muted mb-0 py-3" style="font-size: 12px;">
                            <i class="bi bi-inbox me-1" style="font-size: 16px;"></i><br>
                            Tidak ada transaksi untuk kapster dan tanggal tersebut.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


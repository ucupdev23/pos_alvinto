<div class="row g-2">
    <div class="col-12">

        <div class="card card-app mb-2">
            <div class="card-body">
                <form method="get" action="<?= site_url('admin/laporan'); ?>" class="small">
                    <div class="row g-2">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small">Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm"
                                value="<?= $tanggal_mulai; ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small">Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control form-control-sm"
                                value="<?= $tanggal_selesai; ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small">Kasir</label>
                            <select name="kasir_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_id == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                    <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small">Kapster</label>
                            <select name="karyawan_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($karyawan_list as $ky): ?>
                                    <option value="<?= $ky->id; ?>" <?= $karyawan_id == $ky->id ? 'selected' : ''; ?>>
                                        <?= $ky->nama; ?>
                                    </option>
                                    <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small">Metode Bayar</label>
                            <select name="metode_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($metode_list as $m): ?>
                                    <option value="<?= $m->id; ?>" <?= $metode_id == $m->id ? 'selected' : ''; ?>>
                                        <?= $m->nama; ?>
                                    </option>
                                    <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2 d-flex align-items-end gap-1">
                            <button type="submit" class="btn btn-dark btn-sm w-100 btn-app mt-1">
                                <i class="bi bi-search me-1"></i>
                            </button>
                            <a href="<?= site_url('admin/laporan'); ?>"
                                class="btn btn-outline-secondary btn-sm w-100 btn-app mt-1">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex gap-2 mb-2 justify-content-end">
            <?php
            $params = $_GET;
            unset($params['page']);
            $query_string = http_build_query($params);
            ?>
            <a href="<?= site_url('admin/laporan/export_excel?' . $query_string); ?>" target="_blank"
                class="btn btn-success btn-sm btn-app">
                <i class="bi bi-file-earmark-excel me-1"></i> Excel
            </a>
            <a href="<?= site_url('admin/laporan/export_pdf?' . $query_string); ?>" target="_blank"
                class="btn btn-danger btn-sm btn-app">
                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
        </div>

        <?php if ($rekap): ?>
            <div class="card card-app mb-2">
                <div class="card-body">
                    <h6 class="mb-1">Ringkasan Omzet</h6>
                    <p class="text-muted mb-2" style="font-size: 11px;">
                        Periode <?= date('d/m/Y', strtotime($tanggal_mulai)); ?> -
                        <?= date('d/m/Y', strtotime($tanggal_selesai)); ?>
                    </p>
                    <table class="table table-sm mb-0" style="font-size: 12px;">
                        <tr>
                            <td>Total Omzet</td>
                            <td class="text-end">
                                Rp <?= number_format($rekap->total_omzet ?: 0, 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Total Potongan</td>
                            <td class="text-end"><?= $rekap->total_potong ?: 0; ?> pelanggan</td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php
        endif; ?>

        <div class="card card-app">
            <div class="card-body p-0">
                <?php if (empty($laporan)): ?>
                    <p class="text-center text-muted py-3 mb-0" style="font-size: 12px;">
                        Tidak ada transaksi pada periode & filter ini.
                    </p>
                    <?php
                else: ?>
                    <div class="app-scrollable-table">
                        <?php $start = $offset + 1;
                        $end = min($offset + $per_page, $total_rows);
                        ?>

                        <p class="text-muted px-2 pt-2 mb-1" style="font-size:11px;">
                            Menampilkan <?= $start; ?>–<?= $end; ?> dari <?= $total_rows; ?> data
                        </p>

                        <table class="table table-sm mb-0" style="font-size: 11px;">
                            <thead class="table-light">
                                <tr>
                                    <th>Tgl</th>
                                    <th>Kapster</th>
                                    <th>Jenis</th>
                                    <th>Kasir</th>
                                    <th>Metode</th>
                                    <th class="text-end">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan as $t): ?>
                                    <tr>
                                        <td><?= date('d/m', strtotime($t->tanggal)); ?></td>
                                        <td><?= $t->nama_karyawan; ?></td>
                                        <td><?= $t->jenis_pangkas; ?></td>
                                        <td><?= $t->nama_kasir; ?></td>
                                        <td>
                                            <?php 
                                            $metode = strtolower($t->metode_bayar);
                                            if (strpos($metode, 'qris') !== false): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold" style="font-size: 10px; padding: 3px 8px;">QRIS</span>
                                            <?php elseif (strpos($metode, 'tunai') !== false || strpos($metode, 'cash') !== false): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold" style="font-size: 10px; padding: 3px 8px;">Tunai</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fw-bold" style="font-size: 10px; padding: 3px 8px;"><?= $t->metode_bayar; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            Rp <?= number_format($t->harga, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (!empty($pagination)): ?>
                            <?= $pagination; ?>
                            <?php
                        endif; ?>

                    </div>
                    <?php
                endif; ?>
            </div>
        </div>

    </div>
</div>
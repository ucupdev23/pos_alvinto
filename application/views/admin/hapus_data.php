<div class="row g-2">
    <div class="col-12">
        <!-- Title & Back to Dashboard -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-bold"><i class="bi bi-trash3 me-1 text-danger"></i> Pengaturan Hapus Data</h6>
            <a href="<?= site_url('admin/dashboard'); ?>" class="btn btn-outline-dark btn-sm btn-app py-1 px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Filter Card -->
        <div class="card card-app mb-2 shadow-sm">
            <div class="card-body">
                <h6 class="card-title fw-semibold mb-2" style="font-size: 13px;"><i class="bi bi-filter me-1"></i> Filter Pencarian</h6>
                <form method="get" action="<?= site_url('admin/hapus_data'); ?>" class="small">
                    <div class="row g-2">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label mb-1 text-muted" style="font-size: 11px;">Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control form-control-sm"
                                value="<?= $tanggal_mulai; ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label mb-1 text-muted" style="font-size: 11px;">Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control form-control-sm"
                                value="<?= $tanggal_selesai; ?>">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label mb-1 text-muted" style="font-size: 11px;">Kasir</label>
                            <select name="kasir_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($kasir_list as $k): ?>
                                    <option value="<?= $k->id; ?>" <?= $kasir_id == $k->id ? 'selected' : ''; ?>>
                                        <?= $k->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label mb-1 text-muted" style="font-size: 11px;">Kapster</label>
                            <select name="karyawan_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($karyawan_list as $ky): ?>
                                    <option value="<?= $ky->id; ?>" <?= $karyawan_id == $ky->id ? 'selected' : ''; ?>>
                                        <?= $ky->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label mb-1 text-muted" style="font-size: 11px;">Metode Bayar</label>
                            <select name="metode_id" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                <?php foreach ($metode_list as $m): ?>
                                    <option value="<?= $m->id; ?>" <?= $metode_id == $m->id ? 'selected' : ''; ?>>
                                        <?= $m->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2 d-flex align-items-end gap-1">
                            <button type="submit" class="btn btn-dark btn-sm w-100 btn-app mt-1">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="<?= site_url('admin/hapus_data'); ?>"
                                class="btn btn-outline-secondary btn-sm w-100 btn-app mt-1">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone Card -->
        <div class="card card-app mb-2 border border-danger-subtle bg-danger-subtle bg-opacity-10 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold text-danger mb-2" style="font-size: 13px;"><i class="bi bi-exclamation-octagon me-1"></i> Area Bahaya (Aksi Cepat Hapus)</h6>
                <p class="text-muted mb-3" style="font-size: 11px; line-height: 1.4;">
                    Semua aksi di bawah ini memerlukan konfirmasi keamanan. Harap berhati-hati sebelum mengeksekusi tindakan penghapusan data.
                </p>
                <div class="d-flex flex-column gap-2">
                    <!-- Form Hapus Sesuai Filter -->
                    <form id="form-delete-by-filter" method="post" action="<?= site_url('admin/hapus_data/hapus_by_filter'); ?>">
                        <input type="hidden" name="tanggal_mulai" value="<?= $tanggal_mulai; ?>">
                        <input type="hidden" name="tanggal_selesai" value="<?= $tanggal_selesai; ?>">
                        <input type="hidden" name="kasir_id" value="<?= $kasir_id; ?>">
                        <input type="hidden" name="karyawan_id" value="<?= $karyawan_id; ?>">
                        <input type="hidden" name="metode_id" value="<?= $metode_id; ?>">
                        
                        <button type="button" onclick="confirmDeleteByFilter(event)" class="btn btn-outline-danger btn-sm w-100 btn-app fw-semibold"
                            <?php if (!$tanggal_mulai && !$tanggal_selesai && !$kasir_id && !$karyawan_id && !$metode_id): ?>disabled<?php endif; ?>>
                            <i class="bi bi-funnel me-1"></i> Hapus Semua Sesuai Filter
                        </button>
                    </form>

                    <!-- Form Hapus Semua Data (Reset) -->
                    <form id="form-reset-all" method="post" action="<?= site_url('admin/hapus_data/reset_all'); ?>">
                        <button type="button" onclick="confirmResetAll(event)" class="btn btn-danger btn-sm w-100 btn-app fw-bold">
                            <i class="bi bi-trash3-fill me-1"></i> Hapus Seluruh Data Trial (Reset Total)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data List Card -->
        <div class="card card-app shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($laporan)): ?>
                    <p class="text-center text-muted py-4 mb-0" style="font-size: 12px;">
                        <i class="bi bi-inbox me-1" style="font-size: 18px;"></i><br>
                        Tidak ada transaksi yang cocok untuk ditampilkan atau dihapus.
                    </p>
                <?php else: ?>
                    <?php $start = $offset + 1;
                    $end = min($offset + $per_page, $total_rows);
                    ?>
                    
                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                        <span class="text-muted" style="font-size:11px;">
                            Menampilkan <?= $start; ?>–<?= $end; ?> dari <?= $total_rows; ?> data
                        </span>
                        
                        <!-- Batch Delete Button -->
                        <button type="button" onclick="confirmDeleteSelected(event)" class="btn btn-outline-danger btn-sm btn-app py-0 px-2 fw-semibold" style="font-size: 11px;">
                            <i class="bi bi-trash me-1"></i> Hapus Terpilih
                        </button>
                    </div>

                    <form id="form-delete-selected" method="post" action="<?= site_url('admin/hapus_data/hapus_selected' . ($this->input->server('QUERY_STRING') ? '?' . $this->input->server('QUERY_STRING') : '')); ?>">
                        <div class="table-responsive app-scrollable-table">
                            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 11px;">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="text-center" style="width: 35px;">
                                            <input type="checkbox" id="check-all" class="form-check-input">
                                        </th>
                                        <th>Tgl</th>
                                        <th>Kapster</th>
                                        <th>Jenis</th>
                                        <th>Kasir</th>
                                        <th>Metode</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-center" style="width: 45px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($laporan as $t): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="ids[]" value="<?= $t->id; ?>" class="form-check-input check-item">
                                            </td>
                                            <td><?= date('d/m', strtotime($t->tanggal)); ?></td>
                                            <td class="fw-semibold"><?= $t->nama_karyawan; ?></td>
                                            <td><?= $t->jenis_pangkas; ?></td>
                                            <td class="text-muted"><?= $t->nama_kasir; ?></td>
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
                                            <td class="text-end fw-semibold">
                                                Rp <?= number_format($t->harga, 0, ',', '.'); ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" 
                                                   data-url="<?= site_url('admin/hapus_data/hapus_single/' . $t->id . '?' . $this->input->server('QUERY_STRING')); ?>"
                                                   class="btn btn-sm btn-outline-danger p-1 rounded-circle btn-delete-single"
                                                   style="line-height: 1; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-trash" style="font-size: 11px;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <?php if (!empty($pagination)): ?>
                        <div class="py-2 border-top">
                            <?= $pagination; ?>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
    // Handle Select All Checkbox
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById("check-all");
        if (checkAll) {
            checkAll.addEventListener("change", function() {
                const checkboxes = document.querySelectorAll(".check-item");
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }
    });

    // Single delete buttons handler
    document.querySelectorAll('.btn-delete-single').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            Swal.fire({
                title: 'Hapus Transaksi?',
                text: "Gaji kapster terkait akan dihitung ulang secara otomatis.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // Confirmation dialogs using SweetAlert2
    function confirmResetAll(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Seluruh Data?',
            text: "⚠️ PERHATIAN: Semua data transaksi, gaji karyawan, dan gaji kasir akan dikosongkan secara total.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Second confirmation
                Swal.fire({
                    title: 'Konfirmasi Terakhir',
                    text: "⚠️ PERINGATAN KERAS: Tindakan ini TIDAK DAPAT DIBATALKAN. Anda benar-benar yakin?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal'
                }).then((resultSecond) => {
                    if (resultSecond.isConfirmed) {
                        document.getElementById('form-reset-all').submit();
                    }
                });
            }
        });
    }

    function confirmDeleteSelected(event) {
        event.preventDefault();
        const checkboxes = document.querySelectorAll('input[name="ids[]"]:checked');
        if (checkboxes.length === 0) {
            Swal.fire({
                title: 'Informasi',
                text: "Harap pilih setidaknya satu data transaksi untuk dihapus.",
                icon: 'info',
                confirmButtonColor: '#212529'
            });
            return;
        }
        Swal.fire({
            title: 'Hapus Terpilih?',
            text: `Apakah Anda yakin ingin menghapus ${checkboxes.length} transaksi terpilih? Gaji kapster terkait akan dihitung ulang secara otomatis.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-selected').submit();
            }
        });
    }

    function confirmDeleteByFilter(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Sesuai Filter?',
            text: "Apakah Anda yakin ingin menghapus SEMUA data transaksi hasil filter ini? Tindakan ini juga akan menghapus/menghitung ulang data gaji kapster yang terpengaruh.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-by-filter').submit();
            }
        });
    }
</script>

<?php
$mode   = isset($mode) ? $mode : 'tambah';
$metode = isset($metode) ? $metode : null;
?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-3">
                    <?= $mode === 'tambah' ? 'Tambah Metode Pembayaran' : 'Edit Metode Pembayaran'; ?>
                </h6>

                <form method="post" action="<?= site_url('admin/metode_pembayaran/simpan'); ?>" class="small">
                    <input type="hidden" name="mode" value="<?= $mode; ?>">
                    <?php if ($mode === 'edit' && $metode): ?>
                        <input type="hidden" name="id" value="<?= $metode->id; ?>">
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Nama Metode</label>
                        <input type="text"
                               name="nama"
                               class="form-control form-control-sm"
                               value="<?= $metode ? $metode->nama : ''; ?>"
                               placeholder="Contoh: Cash, QRIS, Transfer"
                               required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Keterangan</label>
                        <input type="text"
                               name="keterangan"
                               class="form-control form-control-sm"
                               value="<?= $metode ? $metode->keterangan : ''; ?>"
                               placeholder="Opsional, misal: QRIS BCA, Transfer Mandiri">
                    </div>

                    <!-- <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="statusSwitch"
                               name="status"
                            <?= (!$metode || $metode->status) ? 'checked' : ''; ?>>
                        <label class="form-check-label small" for="statusSwitch">Aktif</label>
                    </div> -->

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/metode_pembayaran'); ?>"
                           class="btn btn-outline-secondary btn-app">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

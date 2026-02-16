<?php $mode = isset($mode) ? $mode : 'tambah'; ?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-3">
                    <?= $mode == 'tambah' ? 'Tambah Jenis Pangkas' : 'Edit Jenis Pangkas'; ?>
                </h6>

                <form method="post" action="<?= site_url('admin/jenis_pangkas/simpan'); ?>" class="small">
                    <input type="hidden" name="mode" value="<?= $mode; ?>">
                    <?php if ($mode == 'edit' && $jenis): ?>
                        <input type="hidden" name="id" value="<?= $jenis->id; ?>">
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Nama</label>
                        <input type="text" name="nama" class="form-control form-control-sm"
                               value="<?= $jenis ? $jenis->nama : ''; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control form-control-sm"
                               value="<?= $jenis ? $jenis->harga : ''; ?>" required min="0">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control form-control-sm"
                               value="<?= $jenis ? $jenis->keterangan : ''; ?>">
                    </div>

                    <!-- <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch"
                               name="status" <?= (!$jenis || $jenis->status) ? 'checked' : ''; ?>>
                        <label class="form-check-label small" for="statusSwitch">Aktif</label>
                    </div> -->

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/jenis_pangkas'); ?>" class="btn btn-outline-secondary btn-app">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

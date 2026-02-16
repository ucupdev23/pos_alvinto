<?php $mode = isset($mode) ? $mode : 'tambah'; ?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">

                <h6 class="mb-3">
                    <?= $mode == 'tambah' ? 'Tambah Aturan Uang Makan' : 'Edit Aturan Uang Makan'; ?>
                </h6>

                <form method="post" action="<?= site_url('admin/aturan_uang_makan/simpan'); ?>">
                    <input type="hidden" name="mode" value="<?= $mode; ?>">
                    <?php if ($mode == 'edit'): ?>
                        <input type="hidden" name="id" value="<?= $aturan->id; ?>">
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Upah Minimum</label>
                        <input type="number" name="upah_min" class="form-control form-control-sm"
                               value="<?= $mode=='edit' ? $aturan->upah_min : ''; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Upah Maksimum (kosongkan jika tidak ada)</label>
                        <input type="number" name="upah_max" class="form-control form-control-sm"
                               value="<?= ($mode=='edit' && $aturan->upah_max !== null) ? $aturan->upah_max : ''; ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Uang Makan</label>
                        <input type="number" name="uang_makan" class="form-control form-control-sm"
                               value="<?= $mode=='edit' ? $aturan->uang_makan : ''; ?>" required>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/aturan_uang_makan'); ?>" class="btn btn-outline-secondary btn-app">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

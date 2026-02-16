<?php
$mode = isset($mode) ? $mode : 'tambah';
?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-3">
                    <?= $mode == 'tambah' ? 'Tambah Karyawan' : 'Edit Karyawan'; ?>
                </h6>

                <form method="post" action="<?= site_url('admin/karyawan/simpan'); ?>" class="small">
                    <input type="hidden" name="mode" value="<?= $mode; ?>">
                    <?php if ($mode == 'edit' && $karyawan): ?>
                        <input type="hidden" name="id" value="<?= $karyawan->id; ?>">
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Nama</label>
                        <input type="text" name="nama" class="form-control form-control-sm"
                               value="<?= $karyawan ? $karyawan->nama : ''; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">No HP</label>
                        <input type="text" name="no_hp" class="form-control form-control-sm"
                               value="<?= $karyawan ? $karyawan->no_hp : ''; ?>">
                    </div>

                    <!-- <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch"
                               name="status" <?= (!$karyawan || $karyawan->status) ? 'checked' : ''; ?>>
                        <label class="form-check-label small" for="statusSwitch">Aktif</label>
                    </div> -->

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/karyawan'); ?>" class="btn btn-outline-secondary btn-app">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

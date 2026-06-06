<?php
$mode = isset($mode) ? $mode : 'tambah';
?>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-3">
                    <?= $mode == 'tambah' ? 'Tambah Kasir Baru' : 'Edit Kasir'; ?>
                </h6>

                <form method="post" action="<?= site_url('admin/kasir/simpan'); ?>">
                    <input type="hidden" name="mode" value="<?= $mode; ?>">
                    <?php if ($mode == 'edit' && !empty($kasir)): ?>
                        <input type="hidden" name="id" value="<?= $kasir->id; ?>">
                    <?php endif; ?>

                    <div class="mb-2">
                        <label class="form-label small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm"
                               value="<?= ($mode=='edit' && $kasir) ? $kasir->nama : ''; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm"
                               value="<?= ($mode=='edit' && $kasir) ? $kasir->username : ''; ?>" required autocomplete="off">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control form-control-sm"
                               value="<?= ($mode=='edit' && $kasir) ? $kasir->no_hp : ''; ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Tipe Kasir</label>
                        <select name="tipe_kasir" class="form-select form-select-sm" required>
                            <option value="bulanan" <?= ($mode=='edit' && $kasir && $kasir->tipe_kasir == 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                            <option value="helper" <?= ($mode=='edit' && $kasir && $kasir->tipe_kasir == 'helper') ? 'selected' : ''; ?>>Helper</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">
                            Password <?= $mode=='edit' ? '(kosongi jika tidak diganti)' : ''; ?>
                        </label>
                        <input type="password" name="password" class="form-control form-control-sm"
                               <?= $mode=='tambah' ? 'required' : ''; ?>>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/kasir'); ?>" class="btn btn-outline-secondary btn-app">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


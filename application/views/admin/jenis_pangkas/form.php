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
                        <input type="text" id="harga_display" class="form-control form-control-sm"
                               value="<?= $jenis ? number_format($jenis->harga, 0, ',', '.') : ''; ?>" required inputmode="numeric" autocomplete="off">
                        <input type="hidden" name="harga" id="harga_real" value="<?= $jenis ? $jenis->harga : ''; ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control form-control-sm"
                               value="<?= $jenis ? $jenis->keterangan : ''; ?>">
                    </div>

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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputDisplay = document.getElementById('harga_display');
    const inputReal = document.getElementById('harga_real');

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
    }
});
</script>
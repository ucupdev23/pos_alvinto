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
                        <input type="text" id="upah_min_display" class="form-control form-control-sm format-rupiah" data-target="upah_min_real"
                               value="<?= $mode=='edit' ? number_format($aturan->upah_min, 0, ',', '.') : ''; ?>" required inputmode="numeric" autocomplete="off">
                        <input type="hidden" name="upah_min" id="upah_min_real" value="<?= $mode=='edit' ? $aturan->upah_min : ''; ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Upah Maksimum (kosongkan jika tidak ada)</label>
                        <input type="text" id="upah_max_display" class="form-control form-control-sm format-rupiah" data-target="upah_max_real"
                               value="<?= ($mode=='edit' && $aturan->upah_max !== null) ? number_format($aturan->upah_max, 0, ',', '.') : ''; ?>" inputmode="numeric" autocomplete="off">
                        <input type="hidden" name="upah_max" id="upah_max_real" value="<?= ($mode=='edit' && $aturan->upah_max !== null) ? $aturan->upah_max : ''; ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Uang Makan</label>
                        <input type="text" id="uang_makan_display" class="form-control form-control-sm format-rupiah" data-target="uang_makan_real"
                               value="<?= $mode=='edit' ? number_format($aturan->uang_makan, 0, ',', '.') : ''; ?>" required inputmode="numeric" autocomplete="off">
                        <input type="hidden" name="uang_makan" id="uang_makan_real" value="<?= $mode=='edit' ? $aturan->uang_makan : ''; ?>">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.format-rupiah');

    inputs.forEach(inputDisplay => {
        const targetId = inputDisplay.getAttribute('data-target');
        const inputReal = document.getElementById(targetId);

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
});
</script>

<div class="row g-2">
    <div class="col-12">
        <div class="card card-app">
            <div class="card-body">
                <h6 class="mb-3">
                    Edit Uang Makan Kasir <?= ucfirst($aturan->tipe_kasir); ?>
                </h6>

                <form method="post" action="<?= site_url('admin/aturan_uang_makan_kasir/simpan'); ?>">
                    <input type="hidden" name="tipe_kasir" value="<?= $aturan->tipe_kasir; ?>">

                    <div class="mb-2">
                        <label class="form-label small">Tipe Kasir</label>
                        <input type="text" class="form-control form-control-sm" value="<?= ucfirst($aturan->tipe_kasir); ?>" readonly disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Nominal Uang Makan (Rp)</label>
                        <input type="text" id="uang_makan_display" class="form-control form-control-sm"
                               value="<?= number_format($aturan->uang_makan, 0, ',', '.'); ?>" required inputmode="numeric" autocomplete="off">
                        <input type="hidden" name="uang_makan" id="uang_makan_real" value="<?= $aturan->uang_makan; ?>">
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-dark btn-app">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="<?= site_url('admin/aturan_uang_makan_kasir'); ?>" class="btn btn-outline-secondary btn-app">
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
    const inputDisplay = document.getElementById('uang_makan_display');
    const inputReal = document.getElementById('uang_makan_real');

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


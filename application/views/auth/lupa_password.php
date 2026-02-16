<div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 120px);">
    <div class="w-100" style="max-width: 360px;">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-sm py-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php
endif; ?>

        <div class="card card-app">
            <div class="card-body p-4">
                <h5 class="mb-1 text-center">Lupa Password</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px;">
                    Masukkan Username atau No HP terdaftar untuk menerima OTP via WhatsApp.
                </p>

                <form method="post" action="<?= site_url('auth/process_lupa_password'); ?>">
                    <div class="mb-3">
                        <label class="form-label small">Username / No HP</label>
                        <input type="text" name="keyword" class="form-control form-control-sm" required autocomplete="off" placeholder="Contoh: 08123456789">
                    </div>

                    <button class="btn btn-dark w-100 btn-app mt-2" type="submit">
                        <i class="bi bi-send me-1"></i> Kirim OTP
                    </button>
                    
                    <a href="<?= site_url('auth'); ?>" class="btn btn-outline-secondary w-100 btn-app mt-2">
                        Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

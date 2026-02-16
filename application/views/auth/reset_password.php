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
                <h5 class="mb-1 text-center">Reset Password</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px;">
                    Buat password baru yang aman.
                </p>

                <form method="post" action="<?= site_url('auth/process_reset_password'); ?>">
                    <div class="mb-3">
                        <label class="form-label small">Password Baru</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="new_password" id="new_pass" class="form-control form-control-sm" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('new_pass', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Konfirmasi Password</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="confirm_password" id="conf_pass" class="form-control form-control-sm" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass('conf_pass', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 btn-app mt-2" type="submit">
                        Simpan Password
                    </button>
                </form>

                <script>
                    function togglePass(id, btn) {
                        const input = document.getElementById(id);
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        
                        btn.querySelector('i').classList.toggle('bi-eye');
                        btn.querySelector('i').classList.toggle('bi-eye-slash');
                    }
                </script>
            </div>
        </div>
    </div>
</div>

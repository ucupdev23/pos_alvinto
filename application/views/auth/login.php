<div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 120px);">
    <div class="w-100" style="max-width: 360px;">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php
endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2 mb-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php
endif; ?>

        <div class="card card-app">
            <div class="card-body p-4">
                <h5 class="mb-1 text-center">Masuk</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px;">
                    POS Barbershop Alvinto
                </p>

                <form method="post" action="<?= site_url('auth/do_login'); ?>">
                    <div class="mb-3">
                        <label class="form-label small">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="password" id="password" class="form-control form-control-sm" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="<?= site_url('auth/lupa_password'); ?>" class="text-decoration-none small">Lupa Password?</a>
                    </div>

                    <button class="btn btn-dark w-100 btn-app" type="submit">
                        Masuk
                    </button>
                </form>

                <script>
                    const togglePassword = document.querySelector('#togglePassword');
                    const password = document.querySelector('#password');

                    togglePassword.addEventListener('click', function (e) {
                        // toggle the type attribute
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        
                        // toggle the eye slash icon
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });
                </script>
            </div>
        </div>

        <p class="text-center text-muted mt-3" style="font-size: 11px;">
            &copy; <?= date('Y'); ?> Alvinto Barbershop
        </p>
    </div>
</div>

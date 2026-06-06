<style>
    /* CSS overrides khusus untuk halaman Auth agar serasi dengan layout dashboard */
    .app-header {
        display: none !important;
    }
    
    .card-login {
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }

    .brand-container {
        text-align: center;
        margin-bottom: 24px;
        margin-top: 20px;
    }

    .brand-logo-icon {
        width: 56px;
        height: 56px;
        background: #0f172a;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ffffff;
        margin-bottom: 12px;
        box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.15);
    }

    .brand-name {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin-bottom: 2px;
    }

    .brand-tagline {
        font-size: 11px;
        color: #64748b;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .form-label-custom {
        font-size: 11px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        display: block;
        letter-spacing: 0.3px;
    }

    .form-control-login {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
        border-radius: 10px !important;
        padding: 9px 12px !important;
        font-size: 13px !important;
        transition: all 0.2s ease !important;
    }

    .form-control-login:focus {
        border-color: #0f172a !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.08) !important;
        outline: none;
    }

    .btn-login {
        background: #0f172a !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        padding: 10px !important;
        box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.15) !important;
        transition: all 0.2s ease !important;
        font-size: 13px !important;
    }

    .btn-login:hover {
        background: #1e293b !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 10px -1px rgba(15, 23, 42, 0.2) !important;
    }
    
    .btn-cancel {
        background: transparent !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
        font-weight: 500 !important;
        border-radius: 10px !important;
        padding: 10px !important;
        transition: all 0.2s ease !important;
        font-size: 13px !important;
    }

    .btn-cancel:hover {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }
</style>

<div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 40px);">
    <div class="w-100" style="max-width: 360px; padding: 12px;">
        
        <div class="brand-container">
            <div class="brand-logo-icon">
                <i class="bi bi-scissors"></i>
            </div>
            <div class="brand-name">Alvinto Barbershop</div>
            <div class="brand-tagline">Point of Sale System</div>
        </div>

        <div class="card card-login">
            <div class="card-body p-4">
                <h5 class="mb-2 text-center fw-bold" style="color: #0f172a; font-size: 16px;">Lupa Password</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px; color: #64748b !important; line-height: 1.4;">
                    Masukkan Username atau No HP terdaftar untuk menerima OTP via WhatsApp.
                </p>

                <form id="lupaPasswordForm" method="post" action="<?= site_url('auth/process_lupa_password'); ?>">
                    <div class="mb-4">
                        <label class="form-label-custom">USERNAME / NO HP</label>
                        <input type="text" name="keyword" class="form-control form-control-login w-100" required autocomplete="off" placeholder="Contoh: 08123456789">
                    </div>

                    <button class="btn btn-login w-100 mb-2" type="submit" id="btnSubmit">
                        <i class="bi bi-send me-2"></i>Kirim OTP
                    </button>
                    
                    <a href="<?= site_url('auth'); ?>" class="btn btn-cancel w-100 text-center d-block" id="btnBatal">
                        Batal
                    </a>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-4" style="font-size: 11px; color: #64748b !important;">
            &copy; <?= date('Y'); ?> Alvinto Barbershop. All Rights Reserved.
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('lupaPasswordForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnBatal = document.getElementById('btnBatal');
        
        if (form && btnSubmit) {
            form.addEventListener('submit', function() {
                // Ubah tombol submit menjadi status loading
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengirim OTP...';
                
                // Matikan link/tombol Batal
                if (btnBatal) {
                    btnBatal.style.pointerEvents = 'none';
                    btnBatal.style.opacity = '0.5';
                }
            });
        }
    });
</script>

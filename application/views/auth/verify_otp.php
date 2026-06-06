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
        padding: 10px 14px !important;
        font-size: 18px !important;
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
    
    .resend-container {
        text-align: center;
        margin-top: 16px;
    }

    .btn-resend-link {
        color: #0f172a !important;
        font-size: 12px;
        text-decoration: none;
        background: none;
        border: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .btn-resend-link:hover:not(:disabled) {
        color: #475569 !important;
        text-decoration: underline !important;
    }

    .btn-resend-link:disabled {
        color: #94a3b8 !important;
        cursor: not-allowed;
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
                <h5 class="mb-2 text-center fw-bold" style="color: #0f172a; font-size: 16px;">Verifikasi OTP</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px; color: #64748b !important; line-height: 1.4;">
                    Kode OTP telah dikirim ke WhatsApp <br>
                    <strong class="text-dark"><?= $this->session->userdata('reset_no_hp'); ?></strong>
                </p>

                <form method="post" action="<?= site_url('auth/process_verify_otp'); ?>">
                    <div class="mb-4">
                        <label class="form-label-custom text-center mb-2">KODE OTP (6 DIGIT)</label>
                        <input type="number" name="otp" class="form-control form-control-login text-center" required autocomplete="off" placeholder="XXXXXX" style="letter-spacing: 8px; font-weight: bold; font-size: 20px !important;">
                    </div>

                    <button class="btn btn-login w-100" type="submit">
                        Verifikasi Kode
                    </button>
                </form>

                <div class="resend-container">
                    <button id="btnResend" class="btn-resend-link" disabled>
                        Kirim Ulang OTP dalam <span id="timer" class="fw-bold">60</span>s
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-muted mt-4" style="font-size: 11px; color: #64748b !important;">
            &copy; <?= date('Y'); ?> Alvinto Barbershop. All Rights Reserved.
        </p>
    </div>
</div>

<script>
    let timeLeft = 60;
    const timerElem = document.getElementById('timer');
    const btnResend = document.getElementById('btnResend');
    let countdown;

    function startTimer() {
        countdown = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(countdown);
                if (btnResend) {
                    btnResend.disabled = false;
                    btnResend.innerHTML = 'Kirim Ulang OTP';
                }
            } else {
                if (timerElem) timerElem.innerHTML = timeLeft;
                timeLeft -= 1;
            }
        }, 1000);
    }

    startTimer();

    btnResend.addEventListener('click', function() {
        if (!this.disabled) {
            this.disabled = true;
            this.innerHTML = 'Mengirim...';

            fetch('<?= site_url('auth/resend_otp'); ?>')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#0f172a'
                        }).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                        this.disabled = false; 
                        this.innerHTML = 'Kirim Ulang OTP';
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengirim ulang OTP. Coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    this.disabled = false;
                    this.innerHTML = 'Kirim Ulang OTP';
                });
        }
    });
</script>

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
                <h5 class="mb-1 text-center">Verifikasi OTP</h5>
                <p class="text-muted text-center mb-4" style="font-size: 12px;">
                    Kode OTP telah dikirim ke WhatsApp <br>
                    <strong><?= $this->session->userdata('reset_no_hp'); ?></strong>
                </p>

                <form method="post" action="<?= site_url('auth/process_verify_otp'); ?>">
                    <div class="mb-3">
                        <label class="form-label small">Kode OTP (6 Digit)</label>
                        <input type="number" name="otp" class="form-control form-control-sm text-center" required autocomplete="off" placeholder="XXXXXX" style="letter-spacing: 5px; font-weight: bold;">
                    </div>

                    <button class="btn btn-dark w-100 btn-app mt-2" type="submit">
                        Verifikasi
                    </button>
                    
                </form>

                <div class="text-center mt-3">
                    <button id="btnResend" class="btn btn-link btn-sm text-decoration-none p-0" disabled>
                        Kirim Ulang OTP dalam <span id="timer">60</span>s
                    </button>
                </div>
            </div>
        </div>
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
            // Disable button immediately to prevent double click
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
                        alert(data.message);
                        location.reload(); 
                    } else {
                        alert(data.message);
                        this.disabled = false; // Re-enable if failed
                        this.innerHTML = 'Kirim Ulang OTP';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal mengirim ulang OTP. Coba lagi.');
                    this.disabled = false;
                    this.innerHTML = 'Kirim Ulang OTP';
                });
        }
    });
</script>

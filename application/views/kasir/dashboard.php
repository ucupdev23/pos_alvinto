<div class="row g-2">
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-1">Halo, <?= $this->session->userdata('nama'); ?> 👋</h6>
                <p class="text-muted mb-3" style="font-size: 12px;">
                    Silakan pilih menu di bawah untuk mulai input transaksi atau melihat laporan.
                </p>

                <div class="d-grid gap-2">
                    <a href="<?= site_url('kasir/transaksi'); ?>" class="btn btn-dark btn-app">
                        <i class="bi bi-plus-circle me-1"></i> Input Transaksi
                    </a>
                    <a href="<?= site_url('kasir/laporan'); ?>" class="btn btn-outline-dark btn-app">
                        <i class="bi bi-file-earmark-text me-1"></i> Slip Gaji Kapster
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
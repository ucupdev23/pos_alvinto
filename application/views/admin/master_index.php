<div class="row g-2">
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-1">Master Data</h6>
                <p class="text-muted mb-2" style="font-size: 12px;">
                    Kelola data utama yang dipakai kasir untuk input transaksi.
                </p>

                <div class="row g-2">
                    <div class="col-6">
                        <a href="<?= site_url('admin/kasir'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-people me-1"></i> Kasir
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= site_url('admin/karyawan'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-person-badge me-1"></i> Kapster
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= site_url('admin/jenis_pangkas'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-scissors me-1"></i> Jenis Pangkas
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= site_url('admin/metode_pembayaran'); ?>"
                            class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-credit-card me-1"></i> Metode Bayar
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="<?= site_url('admin/aturan_uang_makan'); ?>"
                            class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-cash-coin me-1"></i> Aturan Uang Makan Kapster
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="<?= site_url('admin/aturan_uang_makan_kasir'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-cash-stack me-1"></i> Aturan Uang Makan Kasir
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="<?= site_url('admin/gaji_kasir'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-wallet2 me-1"></i> Gaji Kasir
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="<?= site_url('admin/gaji_karyawan'); ?>" class="btn btn-outline-dark w-100 btn-app">
                            <i class="bi bi-wallet2 me-1"></i> Gaji Kapster (Slip & WA)
                        </a>
                    </div>
                </div>

                <p class="text-muted mt-3 mb-0" style="font-size: 11px;">
                    Tambah / edit di sini akan langsung mempengaruhi pilihan di menu kasir.
                </p>
            </div>
        </div>
    </div>
</div>
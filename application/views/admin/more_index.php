<div class="row g-2">
    <div class="col-12">
        <div class="card card-app mb-2">
            <div class="card-body">
                <h6 class="mb-1">Menu Lainnya</h6>
                <p class="text-muted mb-2" style="font-size: 12px;">
                    Akses fitur tambahan dan pengaturan.
                </p>

                <div class="list-group small">
                    <a href="<?= site_url('admin/gaji_kasir'); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-cash-coin me-2"></i> Gaji Kasir</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <!-- nanti kalau mau setting lain, bisa tambah di sini -->
                </div>

                <hr>

                <button class="btn btn-outline-danger btn-app w-100 mt-2"
                        onclick="if(confirm('Yakin ingin logout?')){ window.location='<?= site_url('auth/logout'); ?>'; }">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>

            </div>
        </div>
    </div>
</div>

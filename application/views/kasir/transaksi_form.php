<div class="row g-2">
    <div class="col-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
                <?php if ($this->session->flashdata('print_struk_id')):
                    $strukId = $this->session->flashdata('print_struk_id');
                    $bayar = $this->session->flashdata('bayar') ?: 0;
                    $kembalian = $this->session->flashdata('kembalian') ?: 0;
                    $printUrlHtml = site_url("kasir/transaksi/struk/{$strukId}?bayar={$bayar}&kembalian={$kembalian}");
                    $printUrlJson = site_url("cetak/struk_json/{$strukId}?bayar={$bayar}&kembalian={$kembalian}");
                    $bluetoothAppUrl = "my.bluetoothprint.scheme://" . $printUrlJson;
                    ?>
                    <div class="mt-2 d-flex gap-2 flex-wrap">
                        <a href="<?= $printUrlHtml; ?>" target="_blank" class="btn btn-sm btn-light text-success border-success fw-bold">
                            <i class="bi bi-laptop me-1"></i> Cetak Laptop
                        </a>
                        <a href="<?= $bluetoothAppUrl; ?>" class="btn btn-sm btn-success fw-bold">
                            <i class="bi bi-bluetooth me-1"></i> Cetak Android
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2 mb-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="card card-app">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <small class="text-muted">Tanggal</small><br>
                        <strong><?= date('d/m/Y'); ?></strong>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Kasir</small><br>
                        <strong><?= $this->session->userdata('nama'); ?></strong>
                    </div>
                </div>

                <hr>

                <form method="post" action="<?= site_url('kasir/transaksi/simpan'); ?>">
                    <div class="mb-3">
                        <label class="form-label small">Kapster</label>
                        <select name="karyawan_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Kapster -</option>
                            <?php foreach ($karyawan as $k): ?>
                                <option value="<?= $k->id; ?>"><?= $k->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Jenis Pangkas</label>
                        <select name="jenis_pangkas_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Jenis Pangkas -</option>
                            <?php foreach ($jenis_pangkas as $j): ?>
                                <option value="<?= $j->id; ?>">
                                    <?= $j->nama; ?> (Rp <?= number_format($j->harga, 0, ',', '.'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Metode Pembayaran</label>
                        <select name="metode_pembayaran_id" id="metode_pembayaran_id" class="form-select form-select-sm"
                            required>
                            <option value="">- Pilih Metode -</option>
                            <?php foreach ($metode_bayar as $m): ?>
                                <option value="<?= $m->id; ?>"><?= $m->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="bayar_section" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small">Bayar (Rp)</label>
                            <input type="text" inputmode="numeric" id="bayar_display" class="form-control form-control-sm text-end"
                                placeholder="0" autocomplete="off">
                            <input type="hidden" name="bayar" id="bayar_real">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Kembalian (Rp)</label>
                            <input type="text" id="kembalian_display"
                                class="form-control form-control-sm text-end text-success fw-bold" placeholder="0"
                                readonly>
                            <input type="hidden" name="kembalian" id="kembalian_real">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 btn-app mt-1">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Transaksi
                    </button>
                </form>

                <p class="text-muted mt-3 mb-0" style="font-size: 11px;">
                    Setiap 1 pelanggan = 1 transaksi. Tanggal otomatis mengikuti hari ini.
                </p>
            </div>
        </div>

        <!-- DAFTAR TRANSAKSI HARI INI -->
        <div class="card card-app mt-3">
            <div class="card-body">
                <h6 class="mb-2" style="font-weight: 600; font-size: 13px;">Transaksi Hari Ini</h6>
                <hr class="my-2">
                <?php if (empty($transaksi_hari_ini)): ?>
                    <p class="text-center text-muted py-3 mb-0" style="font-size: 12px;">
                        Belum ada transaksi hari ini.
                    </p>
                <?php else: ?>
                    <div class="list-group list-group-flush" style="font-size: 12px;">
                        <?php foreach ($transaksi_hari_ini as $t): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-0 bg-transparent border-bottom">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 12px;"><?= $t->nama_karyawan; ?></div>
                                    <div class="text-muted" style="font-size: 10px; margin-top: 1px;">
                                        <?= $t->jenis_pangkas; ?> 
                                        <?php 
                                        $metode = strtolower($t->metode_bayar);
                                        if (strpos($metode, 'qris') !== false): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1 fw-bold" style="font-size: 9px; padding: 2px 6px;">QRIS</span>
                                        <?php elseif (strpos($metode, 'tunai') !== false || strpos($metode, 'cash') !== false): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle ms-1 fw-bold" style="font-size: 9px; padding: 2px 6px;">Tunai</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle ms-1 fw-bold" style="font-size: 9px; padding: 2px 6px;"><?= $t->metode_bayar; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-dark" style="font-size: 12px;">Rp <?= number_format($t->harga, 0, ',', '.'); ?></div>
                                    <div class="mt-1 d-flex gap-1 justify-content-end align-items-center">
                                        <!-- Tombol Cetak -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-success py-0 px-1 dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 10px; line-height: 1.2;" title="Cetak Struk">
                                                <i class="bi bi-printer"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item py-1 text-success" href="<?= site_url("kasir/transaksi/struk/{$t->id}"); ?>" target="_blank" style="font-size: 11px;">
                                                        <i class="bi bi-laptop me-1"></i> Cetak Laptop
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-1 text-success" href="my.bluetoothprint.scheme://<?= site_url("cetak/struk_json/{$t->id}"); ?>" style="font-size: 11px;">
                                                        <i class="bi bi-bluetooth me-1"></i> Cetak Android
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1 btn-edit" 
                                                data-id="<?= $t->id; ?>" 
                                                data-karyawan-id="<?= $t->karyawan_id; ?>" 
                                                data-jenis-pangkas-id="<?= $t->jenis_pangkas_id; ?>" 
                                                data-metode-pembayaran-id="<?= $t->metode_pembayaran_id; ?>"
                                                style="font-size: 10px; line-height: 1.2;" title="Edit Transaksi">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <!-- Tombol Hapus -->
                                        <a href="<?= site_url('kasir/transaksi/hapus/' . $t->id); ?>" 
                                           class="btn btn-sm btn-outline-danger py-0 px-1 btn-delete" 
                                           style="font-size: 10px; line-height: 1.2;" title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header py-2 px-3 border-bottom-0">
                <h6 class="modal-title fw-bold" id="editModalLabel">Edit Transaksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="post" action="">
                <div class="modal-body py-2 px-3">
                    <div class="mb-3">
                        <label class="form-label small">Kapster</label>
                        <select name="karyawan_id" id="edit_karyawan_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Kapster -</option>
                            <?php foreach ($karyawan as $k): ?>
                                <option value="<?= $k->id; ?>"><?= $k->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Jenis Pangkas</label>
                        <select name="jenis_pangkas_id" id="edit_jenis_pangkas_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Jenis Pangkas -</option>
                            <?php foreach ($jenis_pangkas as $j): ?>
                                <option value="<?= $j->id; ?>">
                                    <?= $j->nama; ?> (Rp <?= number_format($j->harga, 0, ',', '.'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Metode Pembayaran</label>
                        <select name="metode_pembayaran_id" id="edit_metode_pembayaran_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Metode -</option>
                            <?php foreach ($metode_bayar as $m): ?>
                                <option value="<?= $m->id; ?>"><?= $m->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="edit_bayar_section" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small">Bayar (Rp)</label>
                            <input type="text" inputmode="numeric" id="edit_bayar_display" class="form-control form-control-sm text-end" placeholder="0" autocomplete="off">
                            <input type="hidden" name="bayar" id="edit_bayar_real">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Kembalian (Rp)</label>
                            <input type="text" id="edit_kembalian_display" class="form-control form-control-sm text-end text-success fw-bold" placeholder="0" readonly>
                            <input type="hidden" name="kembalian" id="edit_kembalian_real">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2 px-3 border-top-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-app" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-dark btn-app">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .no-caret::after {
        display: none !important;
    }
    
    /* Agar dialog sweetalert2 pas dengan aesthetic mobile */
    .swal2-popup {
        font-family: inherit !important;
        font-size: 0.85rem !important;
        border-radius: 16px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metodeSelect = document.getElementById('metode_pembayaran_id');
        const jenisPangkasSelect = document.querySelector('select[name="jenis_pangkas_id"]');
        const bayarSection = document.getElementById('bayar_section');
        const bayarDisplay = document.getElementById('bayar_display');
        const bayarReal = document.getElementById('bayar_real');
        const kembalianDisplay = document.getElementById('kembalian_display');
        const kembalianReal = document.getElementById('kembalian_real');

        // Modal elements
        const editModalEl = document.getElementById('editModal');
        const editModal = new bootstrap.Modal(editModalEl);
        const editForm = document.getElementById('editForm');
        
        const editKaryawanSelect = document.getElementById('edit_karyawan_id');
        const editJenisPangkasSelect = document.getElementById('edit_jenis_pangkas_id');
        const editMetodeSelect = document.getElementById('edit_metode_pembayaran_id');
        
        const editBayarSection = document.getElementById('edit_bayar_section');
        const editBayarDisplay = document.getElementById('edit_bayar_display');
        const editBayarReal = document.getElementById('edit_bayar_real');
        const editKembalianDisplay = document.getElementById('edit_kembalian_display');
        const editKembalianReal = document.getElementById('edit_kembalian_real');

        // Get current price
        function getCurrentPrice() {
            if (!jenisPangkasSelect.value) return 0;
            const text = jenisPangkasSelect.options[jenisPangkasSelect.selectedIndex].text;
            // Text is like: Dewasa (Rp 25.000)
            const match = text.match(/Rp\s*([\d.]+)/);
            if (match) {
                return parseInt(match[1].replace(/\./g, ''));
            }
            return 0;
        }

        function calculateKembalian() {
            const price = getCurrentPrice();
            const bayar = parseInt(bayarReal.value) || 0;
            let kembalian = 0;
            if (bayar > price) {
                kembalian = bayar - price;
            }
            kembalianReal.value = kembalian;
            kembalianDisplay.value = kembalian.toLocaleString('id-ID');
        }

        metodeSelect.addEventListener('change', function () {
            if (this.value === '1') { // Assuming ID 1 is Cash
                bayarSection.style.display = 'block';
                bayarDisplay.required = true;
            } else {
                bayarSection.style.display = 'none';
                bayarDisplay.required = false;
                bayarReal.value = '';
                bayarDisplay.value = '';
                kembalianReal.value = '';
                kembalianDisplay.value = '';
            }
        });

        jenisPangkasSelect.addEventListener('change', calculateKembalian);

        bayarDisplay.addEventListener('input', function (e) {
            let val = this.value.replace(/[^0-9]/g, '');
            bayarReal.value = val;

            if (val !== '') {
                this.value = parseInt(val).toLocaleString('id-ID');
            } else {
                this.value = '';
            }
            calculateKembalian();
        });

        // --- Edit Modal Functions ---
        function getEditCurrentPrice() {
            if (!editJenisPangkasSelect.value) return 0;
            const text = editJenisPangkasSelect.options[editJenisPangkasSelect.selectedIndex].text;
            const match = text.match(/Rp\s*([\d.]+)/);
            if (match) {
                return parseInt(match[1].replace(/\./g, ''));
            }
            return 0;
        }

        function calculateEditKembalian() {
            const price = getEditCurrentPrice();
            const bayar = parseInt(editBayarReal.value) || 0;
            let kembalian = 0;
            if (bayar > price) {
                kembalian = bayar - price;
            }
            editKembalianReal.value = kembalian;
            editKembalianDisplay.value = kembalian.toLocaleString('id-ID');
        }

        function triggerEditMetodeChange() {
            if (editMetodeSelect.value === '1') { // Tunai
                editBayarSection.style.display = 'block';
                editBayarDisplay.required = true;
            } else {
                editBayarSection.style.display = 'none';
                editBayarDisplay.required = false;
                editBayarReal.value = '';
                editBayarDisplay.value = '';
                editKembalianReal.value = '';
                editKembalianDisplay.value = '';
            }
        }

        editMetodeSelect.addEventListener('change', triggerEditMetodeChange);
        editJenisPangkasSelect.addEventListener('change', calculateEditKembalian);

        editBayarDisplay.addEventListener('input', function (e) {
            let val = this.value.replace(/[^0-9]/g, '');
            editBayarReal.value = val;

            if (val !== '') {
                this.value = parseInt(val).toLocaleString('id-ID');
            } else {
                this.value = '';
            }
            calculateEditKembalian();
        });

        // Click Edit Handler
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const karyawanId = this.getAttribute('data-karyawan-id');
                const jenisPangkasId = this.getAttribute('data-jenis-pangkas-id');
                const metodeId = this.getAttribute('data-metode-pembayaran-id');
                
                // Set form action
                editForm.action = "<?= site_url('kasir/transaksi/update/'); ?>" + id;
                
                // Set values
                editKaryawanSelect.value = karyawanId;
                editJenisPangkasSelect.value = jenisPangkasId;
                editMetodeSelect.value = metodeId;
                
                // Toggle Cash section
                triggerEditMetodeChange();
                
                // Show modal
                editModal.show();
            });
        });

        // SweetAlert2 Delete Confirmation
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                Swal.fire({
                    title: 'Hapus Transaksi?',
                    text: "Apakah Anda yakin? Gaji kapster terkait akan dihitung ulang secara otomatis.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
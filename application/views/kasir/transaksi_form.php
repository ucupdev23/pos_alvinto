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
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metodeSelect = document.getElementById('metode_pembayaran_id');
        const jenisPangkasSelect = document.querySelector('select[name="jenis_pangkas_id"]');
        const bayarSection = document.getElementById('bayar_section');
        const bayarDisplay = document.getElementById('bayar_display');
        const bayarReal = document.getElementById('bayar_real');
        const kembalianDisplay = document.getElementById('kembalian_display');
        const kembalianReal = document.getElementById('kembalian_real');

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


    });
</script>
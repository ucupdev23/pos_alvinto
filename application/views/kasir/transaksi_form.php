<div class="row g-2">
    <div class="col-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
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
                        <label class="form-label small">Karyawan</label>
                        <select name="karyawan_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Karyawan -</option>
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
                        <select name="metode_pembayaran_id" class="form-select form-select-sm" required>
                            <option value="">- Pilih Metode -</option>
                            <?php foreach ($metode_bayar as $m): ?>
                                <option value="<?= $m->id; ?>"><?= $m->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
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

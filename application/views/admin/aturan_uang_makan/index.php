<div class="row g-2">
    <div class="col-12">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Daftar Aturan Uang Makan</h6>
            <a href="<?= site_url('admin/aturan_uang_makan/tambah'); ?>" class="btn btn-dark btn-sm btn-app">
                <i class="bi bi-plus-circle me-1"></i> Aturan Baru
            </a>
        </div>

        <div class="card card-app">
            <div class="card-body p-2">
                <?php if (empty($list)): ?>
                    <p class="text-center text-muted mb-0" style="font-size: 12px;">
                        Belum ada aturan.
                    </p>
                <?php else: ?>
                    <table class="table table-sm mb-0" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Upah Min</th>
                            <th>Upah Max</th>
                            <th>Uang Makan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($list as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>Rp <?= number_format($r->upah_min,0,',','.'); ?></td>
                                <td><?= $r->upah_max ? 'Rp '.number_format($r->upah_max,0,',','.') : '∞'; ?></td>
                                <td>Rp <?= number_format($r->uang_makan,0,',','.'); ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('admin/aturan_uang_makan/edit/'.$r->id); ?>" class="btn btn-sm btn-outline-dark btn-app">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/aturan_uang_makan/hapus/'.$r->id); ?>"
                                       class="btn btn-sm btn-outline-danger btn-app"
                                       onclick="return confirm('Nonaktifkan aturan ini?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

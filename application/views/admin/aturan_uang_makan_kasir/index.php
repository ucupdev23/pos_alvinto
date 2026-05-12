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

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Aturan Uang Makan Kasir</h6>
        </div>

        <div class="card card-app">
            <div class="card-body p-2">
                <table class="table table-sm mb-0" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe Kasir</th>
                        <th class="text-end">Uang Makan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach ($list as $a): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?php if ($a->tipe_kasir == 'bulanan'): ?>
                                    <span class="badge bg-primary">Bulanan</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Helper</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">Rp <?= number_format($a->uang_makan, 0, ',', '.'); ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('admin/aturan_uang_makan_kasir/edit/'.$a->tipe_kasir); ?>" class="btn btn-sm btn-outline-dark btn-app">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

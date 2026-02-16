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
            <h6 class="mb-0">Daftar Kasir</h6>
            <a href="<?= site_url('admin/kasir/tambah'); ?>" class="btn btn-dark btn-sm btn-app">
                <i class="bi bi-plus-circle me-1"></i> Kasir Baru
            </a>
        </div>

        <div class="card card-app">
            <div class="card-body p-2">
                <?php if (empty($kasir_list)): ?>
                    <p class="text-center text-muted mb-0" style="font-size: 12px;">
                        Belum ada kasir terdaftar.
                    </p>
                <?php else: ?>
                    <table class="table table-sm mb-0" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>No HP</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($kasir_list as $k): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $k->nama; ?></td>
                                <td><?= $k->username; ?></td>
                                <td><?= $k->no_hp; ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('admin/kasir/edit/'.$k->id); ?>" class="btn btn-sm btn-outline-dark btn-app">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/kasir/hapus/'.$k->id); ?>"
                                       class="btn btn-sm btn-outline-danger btn-app"
                                       onclick="return confirm('Nonaktifkan kasir ini?');">
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

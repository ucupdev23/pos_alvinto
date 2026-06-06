<div class="row g-2">
    <div class="col-12">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success py-2 mb-2"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2 mb-2"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Daftar Kapster</h6>
            <a href="<?= site_url('admin/karyawan/tambah'); ?>" class="btn btn-dark btn-sm btn-app">
                <i class="bi bi-plus-circle me-1"></i> Baru
            </a>
        </div>

        <div class="card card-app">
            <div class="card-body p-0">
                <?php if (empty($list)): ?>
                    <p class="text-center text-muted py-3 mb-0" style="font-size: 12px;">
                        Belum ada kapster.
                    </p>
                <?php else: ?>
                    <div class="app-scrollable-table">
                        <table class="table table-sm mb-0" style="font-size: 11px;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <!-- <th>Status</th> -->
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($list as $k): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $k->nama; ?></td>
                                        <td><?= $k->no_hp; ?></td>
                                        <!-- <td>
                                        <?php if ($k->status): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td> -->
                                        <td class="text-end">
                                            <a href="<?= site_url('admin/karyawan/edit/' . $k->id); ?>"
                                                class="btn btn-sm btn-outline-dark btn-app">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if ($k->status): ?>
                                                <a href="<?= site_url('admin/karyawan/hapus/' . $k->id); ?>"
                                                    class="btn btn-sm btn-outline-danger btn-app"
                                                    data-confirm="Nonaktifkan kapster ini?">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
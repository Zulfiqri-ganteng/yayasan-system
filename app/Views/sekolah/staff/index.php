<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Staff Sekolah</h4>
            <small class="text-muted">Kelola data tenaga pendidik sekolah</small>
        </div>

        <a href="<?= base_url('sekolah/staff/create') ?>" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah Staff
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success shadow-sm">
            <?= session('success') ?>
        </div>
    <?php endif ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="70">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Wali Kelas</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Sosial</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($staff)): ?>
                        <?php foreach ($staff as $row): ?>
                            <tr>

                                <!-- FOTO -->
                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="<?= base_url('uploads/staff/' . $row['foto']) ?>"
                                            class="rounded-circle"
                                            style="width:50px;height:50px;object-fit:cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:50px;height:50px;">
                                            <i class="fa fa-user text-muted"></i>
                                        </div>
                                    <?php endif ?>
                                </td>

                                <!-- NAMA -->
                                <td>
                                    <div class="fw-semibold"><?= esc($row['nama']) ?></div>
                                </td>

                                <!-- JABATAN -->
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <?= esc($row['jabatan']) ?>
                                    </span>
                                </td>

                                <!-- WALI KELAS -->
                                <td>
                                    <?php if (!empty($row['wali_kelas'])): ?>
                                        <span class="badge bg-warning-subtle text-dark">
                                            <?= esc($row['wali_kelas']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>

                                <!-- URUTAN -->
                                <td><?= esc($row['urutan']) ?></td>

                                <!-- STATUS -->
                                <td>
                                    <span class="badge bg-<?= $row['status'] === 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= esc($row['status']) ?>
                                    </span>
                                </td>

                                <!-- SOSIAL MEDIA -->
                                <td>
                                    <?php
                                    $hasSocial = false;
                                    ?>

                                    <?php if (!empty($row['instagram'])): ?>
                                        <i class="fab fa-instagram text-danger me-1"></i>
                                        <?php $hasSocial = true; ?>
                                    <?php endif ?>

                                    <?php if (!empty($row['facebook'])): ?>
                                        <i class="fab fa-facebook text-primary me-1"></i>
                                        <?php $hasSocial = true; ?>
                                    <?php endif ?>

                                    <?php if (!empty($row['linkedin'])): ?>
                                        <i class="fab fa-linkedin text-info"></i>
                                        <?php $hasSocial = true; ?>
                                    <?php endif ?>

                                    <?php if (!$hasSocial): ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>

                                <!-- AKSI -->
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                <td>
                                    <a href="<?= base_url('sekolah/staff/edit/' . $row['id']) ?>"
                                        class="btn btn-sm btn-warning me-1">
                                        <i class="typcn typcn-edit"></i>
                                    </a>

                                    <a href="<?= base_url('sekolah/staff/delete/' . $row['id']) ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus staff ini?')">
                                        <i class="typcn typcn-trash"></i>
                                    </a>
                                </td>


        </div>
        </td>


        </tr>
    <?php endforeach ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="text-center text-muted py-4">
            Belum ada data staff.
        </td>
    </tr>
<?php endif ?>

</tbody>
</table>

    </div>
</div>

</div>

<?= $this->endSection() ?>
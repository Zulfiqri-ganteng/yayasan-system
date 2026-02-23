<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <!-- <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-users text-primary me-2"></i>
        Admin Sekolah
    </h4> -->

    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
        <i class="typcn typcn-user-add-outline me-1"></i>
        Tambah Admin Sekolah
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="card-body table-responsive">

        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th width="60">#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Sekolah</th>
                    <th>Status</th>
                    <th width="320">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                            Belum ada admin sekolah
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <!-- USERNAME -->
                        <td class="fw-semibold">
                            <i class="typcn typcn-user me-1 text-primary"></i>
                            <?= esc($u['username']) ?>
                        </td>
                        <td class="fw-semibold">
                            <i class="typcn typcn-email me-1 text-primary"></i>
                            <?= esc($u['email']) ?>
                        </td>

                        <!-- SEKOLAH -->
                        <td>
                            <i class="typcn typcn-home-outline me-1 text-muted"></i>
                            <?= esc($u['nama_sekolah'] ?? '-') ?>
                            <?php if (!empty($u['jenjang'])): ?>
                                <span class="badge bg-light text-dark ms-1">
                                    <?= strtoupper($u['jenjang']) ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <?php if ((int)$u['status'] === 1): ?>
                                <span class="badge bg-success">
                                    <i class="typcn typcn-tick me-1"></i> Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="typcn typcn-times me-1"></i> Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- AKSI -->
                        <td>
                            <div class="d-flex flex-wrap gap-1">

                                <!-- EDIT -->
                                <a href="<?= base_url('admin/users/edit/' . $u['id']) ?>"
                                    class="btn btn-sm btn-outline-warning">
                                    <i class="typcn typcn-edit"></i>
                                </a>

                                <!-- RESET PASSWORD -->
                                <form action="<?= base_url('admin/users/reset-password/' . $u['id']) ?>"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm(
                        'Reset password admin sekolah ini?\n\n' +
                        'Username & Password menjadi:\n<?= esc($u['username']) ?>'
                      )">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="typcn typcn-refresh-outline"></i>
                                    </button>
                                </form>

                                <!-- DELETE -->
                                <form action="<?= base_url('admin/users/delete/' . $u['id']) ?>"
                                    method="post"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus admin ini secara permanen?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="typcn typcn-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>

    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">

    <?php foreach ($users as $u): ?>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <div class="fw-semibold mb-1">
                    <i class="typcn typcn-user text-primary me-1"></i>
                    <?= esc($u['username']) ?>
                </div>
                <div class="fw-semibold mb-1">
                    <i class="typcn typcn-email text-primary me-1"></i>
                    <?= esc($u['email']) ?>
                </div>

                <div class="text-muted mb-2">
                    <i class="typcn typcn-home-outline me-1"></i>
                    <?= esc($u['nama_sekolah'] ?? '-') ?>
                </div>

                <div class="mb-3">
                    <?= (int)$u['status'] === 1
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                </div>

                <div class="d-grid gap-2">

                    <a href="<?= base_url('admin/users/edit/' . $u['id']) ?>"
                        class="btn btn-outline-warning btn-sm">
                        <i class="typcn typcn-edit me-1"></i> Edit
                    </a>

                    <form action="<?= base_url('admin/users/reset-password/' . $u['id']) ?>"
                        method="post"
                        onsubmit="return confirm('Reset password admin ini?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-warning btn-sm w-100">
                            <i class="typcn typcn-refresh-outline me-1"></i>
                            Reset Password
                        </button>
                    </form>

                    <form action="<?= base_url('admin/users/delete/' . $u['id']) ?>"
                        method="post"
                        onsubmit="return confirm('Hapus admin ini?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm w-100">
                            <i class="typcn typcn-trash me-1"></i>
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>
    <?php endforeach ?>

</div>

<?= $this->endSection() ?>
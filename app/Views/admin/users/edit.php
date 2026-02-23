<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= PAGE HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 d-flex align-items-center">
            <i class="typcn typcn-edit text-primary me-2"></i>
            Edit Admin Sekolah
        </h4>
        <small class="text-muted">
            Kelola akun admin sekolah (tanpa mengubah password)
        </small>
    </div>

    <a href="<?= base_url('admin/users') ?>"
        class="btn btn-light">
        <i class="typcn typcn-arrow-back-outline me-1"></i>
        Kembali
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4">

    <!-- ================= FORM ================= -->
    <div class="col-lg-7">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="typcn typcn-user-outline me-1"></i>
                    Form Edit Admin Sekolah
                </h6>
            </div>

            <div class="card-body">

                <form method="post"
                    action="<?= base_url('admin/users/update/' . $user['id']) ?>">

                    <?= csrf_field() ?>

                    <!-- SEKOLAH -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="typcn typcn-home-outline me-1"></i>
                            Sekolah
                        </label>

                        <select name="sekolah_id"
                            class="form-select"
                            required>
                            <?php foreach ($sekolah as $s): ?>
                                <option value="<?= $s['id'] ?>"
                                    <?= $s['id'] == $user['sekolah_id'] ? 'selected' : '' ?>>
                                    <?= esc($s['nama_sekolah']) ?>
                                    (<?= strtoupper($s['jenjang']) ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- USERNAME -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="typcn typcn-user me-1"></i>
                            Username Login
                        </label>

                        <input type="text"
                            name="username"
                            class="form-control"
                            value="<?= esc($user['username']) ?>"
                            required>

                        <small class="text-muted">
                            Digunakan untuk login admin sekolah
                        </small>
                    </div>
                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="typcn typcn-mail me-1"></i>
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            value="<?= esc($user['email']) ?>"
                            required>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="typcn typcn-power-outline me-1"></i>
                            Status Akun
                        </label>

                        <select name="status"
                            class="form-select">
                            <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>
                                Aktif
                            </option>
                            <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <!-- ACTION -->
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <button type="submit"
                            class="btn btn-primary px-4">
                            <i class="typcn typcn-tick-outline me-1"></i>
                            Simpan Perubahan
                        </button>

                        <span class="text-muted small">
                            <i class="typcn typcn-lock-closed-outline me-1"></i>
                            Password tidak diubah di halaman ini
                        </span>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= INFO PANEL ================= -->
    <div class="col-lg-5">

        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="typcn typcn-info-large-outline me-1"></i>
                    Informasi Akun
                </h6>
            </div>

            <div class="card-body">

                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Role</td>
                        <td>
                            <span class="badge bg-primary">
                                Admin Sekolah
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Sekolah Aktif</td>
                        <td><?= esc($user['nama_sekolah'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <?php if ($user['status'] == 1): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="alert alert-warning small mb-0">
                    <i class="typcn typcn-warning-outline me-1"></i>
                    Perubahan username atau status akan langsung
                    mempengaruhi akses login admin sekolah.
                </div>

            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
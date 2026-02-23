<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <!-- <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-school text-primary me-2"></i>
        Manajemen Sekolah
    </h4> -->

    <a href="<?= base_url('admin/sekolah/create') ?>"
        class="btn btn-primary">
        <i class="typcn typcn-plus-outline me-1"></i>
        Tambah Sekolah
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th width="60">#</th>
                    <th>Nama Sekolah</th>
                    <th width="140">Jenjang</th>
                    <th width="120">Status</th>
                    <th width="320">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($sekolah as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td class="fw-semibold">
                            <i class="typcn typcn-home-outline me-1 text-primary"></i>
                            <?= esc($s['nama_sekolah']) ?>
                        </td>

                        <td>
                            <span class="badge bg-info text-uppercase">
                                <i class="typcn typcn-flow-children me-1"></i>
                                <?= esc(strtoupper($s['jenjang'])) ?>
                            </span>
                        </td>

                        <td>
                            <?php if ($s['status']): ?>
                                <span class="badge bg-success">
                                    <i class="typcn typcn-tick me-1"></i>
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="typcn typcn-times me-1"></i>
                                    Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if (strtolower($s['jenjang']) !== 'yayasan'): ?>

                                <a href="<?= base_url('admin/sekolah/edit/' . $s['id']) ?>"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="typcn typcn-edit"></i>
                                </a>

                                <a href="<?= base_url('admin/sekolah-fitur/' . $s['id']) ?>"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="typcn typcn-puzzle-outline"></i>
                                    Fitur
                                </a>

                                <a href="<?= base_url('admin/sekolah/toggle/' . $s['id']) ?>"
                                    class="btn btn-sm <?= $s['status'] ? 'btn-danger' : 'btn-success' ?>"
                                    onclick="return confirm('Yakin ingin mengubah status sekolah ini?')">
                                    <i class="typcn typcn-power me-1"></i>
                                    <?= $s['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                                </a>

                            <?php else: ?>
                                <span class="text-muted d-flex align-items-center">
                                    <i class="typcn typcn-lock-closed-outline me-1"></i>
                                    Terkunci
                                </span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">

    <?php foreach ($sekolah as $s): ?>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <div class="fw-semibold mb-1">
                    <i class="typcn typcn-home-outline me-1 text-primary"></i>
                    <?= esc($s['nama_sekolah']) ?>
                </div>

                <div class="mb-2">
                    <span class="badge bg-info text-uppercase me-1">
                        <?= esc($s['jenjang']) ?>
                    </span>

                    <?php if ($s['status']): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php endif; ?>
                </div>

                <?php if (strtolower($s['jenjang']) !== 'yayasan'): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/sekolah/edit/' . $s['id']) ?>"
                            class="btn btn-sm btn-warning">
                            <i class="typcn typcn-edit me-1"></i>
                            Edit
                        </a>

                        <a href="<?= base_url('admin/sekolah-fitur/' . $s['id']) ?>"
                            class="btn btn-sm btn-outline-primary">
                            <i class="typcn typcn-puzzle-outline me-1"></i>
                            Kelola Fitur
                        </a>

                        <a href="<?= base_url('admin/sekolah/toggle/' . $s['id']) ?>"
                            class="btn btn-sm <?= $s['status'] ? 'btn-danger' : 'btn-success' ?>"
                            onclick="return confirm('Yakin ingin mengubah status sekolah ini?')">
                            <i class="typcn typcn-power me-1"></i>
                            <?= $s['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-muted mt-2">
                        <i class="typcn typcn-lock-closed-outline me-1"></i>
                        Sekolah Yayasan (Terkunci)
                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach ?>

</div>

<?= $this->endSection() ?>
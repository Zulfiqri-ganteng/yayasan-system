<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-mortar-board text-primary me-2"></i>
        Jurusan Website
    </h4>

    <a href="<?= base_url('sekolah/jurusan/create') ?>"
        class="btn btn-primary">
        <i class="typcn typcn-plus-outline me-1"></i>
        Tambah Jurusan
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php foreach (session()->getFlashdata('error') as $err): ?>
            <div><?= esc($err) ?></div>
        <?php endforeach ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif ?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th width="180">Foto</th>
                    <th width="120">Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($jurusan)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                            Belum ada jurusan
                        </td>
                    </tr>
                <?php endif ?>

                <?php foreach ($jurusan as $i => $row): ?>

                    <?php
                    $foto = !empty($row['foto_cover']) &&
                        file_exists(FCPATH . 'uploads/sekolah/jurusan/' . $row['foto_cover'])
                        ? base_url('uploads/sekolah/jurusan/' . $row['foto_cover'])
                        : base_url('assets/img/default.jpg');
                    ?>

                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td class="fw-semibold">
                            <i class="typcn typcn-book text-primary me-1"></i>
                            <?= esc($row['nama']) ?>
                        </td>

                        <td>
                            <img src="<?= $foto ?>"
                                style="width:140px; height:90px; object-fit:cover;"
                                class="rounded shadow-sm">
                        </td>

                        <td>
                            <span class="badge bg-<?= $row['status'] == 'publish' ? 'success' : 'secondary' ?>">
                                <?= esc($row['status']) ?>
                            </span>
                        </td>

                        <td>

                            <a href="<?= base_url('sekolah/jurusan/edit/' . $row['id']) ?>"
                                class="btn btn-sm btn-warning me-1">
                                <i class="typcn typcn-edit"></i>
                            </a>

                            <form action="<?= base_url('sekolah/jurusan/delete/' . $row['id']) ?>"
                                method="post"
                                class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus jurusan ini?')">
                                    <i class="typcn typcn-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>

                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">

    <?php if (empty($jurusan)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
                <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                Belum ada jurusan
            </div>
        </div>
    <?php endif ?>

    <?php foreach ($jurusan as $row): ?>

        <?php
        $foto = !empty($row['foto_cover']) &&
            file_exists(FCPATH . 'uploads/sekolah/jurusan/' . $row['foto_cover'])
            ? base_url('uploads/sekolah/jurusan/' . $row['foto_cover'])
            : base_url('assets/img/default.jpg');
        ?>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <div class="fw-semibold mb-2">
                    <?= esc($row['nama']) ?>
                </div>

                <img src="<?= $foto ?>"
                    class="img-fluid rounded shadow-sm mb-3"
                    style="max-height:180px; object-fit:cover;">

                <div class="mb-2">
                    <span class="badge bg-<?= $row['status'] == 'publish' ? 'success' : 'secondary' ?>">
                        <?= esc($row['status']) ?>
                    </span>
                </div>

                <div class="d-grid gap-2">
                    <a href="<?= base_url('sekolah/jurusan/edit/' . $row['id']) ?>"
                        class="btn btn-sm btn-warning">
                        <i class="typcn typcn-edit me-1"></i> Edit
                    </a>

                    <form action="<?= base_url('sekolah/jurusan/delete/' . $row['id']) ?>"
                        method="post">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="btn btn-sm btn-danger w-100"
                            onclick="return confirm('Hapus jurusan ini?')">
                            <i class="typcn typcn-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>

    <?php endforeach ?>

</div>

<?= $this->endSection() ?>
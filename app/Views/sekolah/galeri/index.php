<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-image-outline text-primary me-2"></i>
        Galeri Sekolah
    </h4>

    <a href="<?= base_url('sekolah/galeri/create') ?>"
       class="btn btn-primary">
        <i class="typcn typcn-plus-outline me-1"></i>
        Tambah Galeri
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
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
                    <th>Judul</th>
                    <th width="180">Foto</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($galeri)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                            Belum ada galeri
                        </td>
                    </tr>
                <?php endif ?>

                <?php foreach ($galeri as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td class="fw-semibold">
                            <i class="typcn typcn-image me-1 text-primary"></i>
                            <?= esc($row['judul']) ?>
                        </td>

                        <td>
                            <img src="<?= base_url('uploads/sekolah/galeri/' . $row['gambar']) ?>"
                                 class="rounded shadow-sm"
                                 style="width:140px; height:90px; object-fit:cover;">
                        </td>

                        <td>
                            <a href="<?= base_url('sekolah/galeri/edit/' . $row['id']) ?>"
                               class="btn btn-sm btn-warning me-1">
                                <i class="typcn typcn-edit"></i>
                            </a>

                            <a href="<?= base_url('sekolah/galeri/delete/' . $row['id']) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Hapus foto galeri ini?')">
                                <i class="typcn typcn-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">

    <?php if (empty($galeri)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
                <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                Belum ada galeri
            </div>
        </div>
    <?php endif ?>

    <?php foreach ($galeri as $row): ?>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <div class="fw-semibold mb-2">
                    <i class="typcn typcn-image-outline text-primary me-1"></i>
                    <?= esc($row['judul']) ?>
                </div>

                <img src="<?= base_url('uploads/sekolah/galeri/' . $row['gambar']) ?>"
                     class="img-fluid rounded shadow-sm mb-3"
                     style="max-height:180px; object-fit:cover;">

                <div class="d-grid gap-2">
                    <a href="<?= base_url('sekolah/galeri/edit/' . $row['id']) ?>"
                       class="btn btn-sm btn-warning">
                        <i class="typcn typcn-edit me-1"></i>
                        Edit
                    </a>

                    <a href="<?= base_url('sekolah/galeri/delete/' . $row['id']) ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus foto galeri ini?')">
                        <i class="typcn typcn-trash me-1"></i>
                        Hapus
                    </a>
                </div>

            </div>
        </div>
    <?php endforeach ?>

</div>

<?= $this->endSection() ?>

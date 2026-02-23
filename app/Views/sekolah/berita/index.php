<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-news text-primary me-2"></i>
        Berita Sekolah
    </h4>

    <a href="<?= base_url('sekolah/berita/create') ?>"
        class="btn btn-primary">
        <i class="typcn typcn-plus-outline me-1"></i>
        Tambah Berita
    </a>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card shadow-sm border-0 d-none d-md-block">
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($berita)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                            Belum ada berita
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($berita as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td class="fw-semibold d-flex align-items-center">
                            <i class="typcn typcn-document-text me-1 text-primary"></i>
                            <?= esc($row['judul']) ?>
                        </td>

                        <td>
                            <?php if ($row['status'] === 'publish'): ?>
                                <span class="badge bg-success">
                                    <i class="typcn typcn-tick me-1"></i>
                                    Publish
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="typcn typcn-times me-1"></i>
                                    Draft
                                </span>
                            <?php endif; ?>
                        </td>

                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                        <td>
                            <a href="<?= base_url('sekolah/berita/edit/' . $row['id']) ?>"
                                class="btn btn-sm btn-warning me-1">
                                <i class="typcn typcn-edit"></i>
                            </a>

                            <a href="<?= base_url('sekolah/berita/delete/' . $row['id']) ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Hapus berita ini?')">
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

    <?php if (empty($berita)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center text-muted py-5">
                <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                Belum ada berita
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($berita as $row): ?>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold">
                        <i class="typcn typcn-document-text me-1 text-primary"></i>
                        <?= esc($row['judul']) ?>
                    </span>

                    <?php if ($row['status'] === 'publish'): ?>
                        <span class="badge bg-success">Publish</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Draft</span>
                    <?php endif; ?>
                </div>

                <small class="text-muted d-block mb-3">
                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                </small>

                <div class="d-grid gap-2">
                    <a href="<?= base_url('sekolah/berita/edit/' . $row['id']) ?>"
                        class="btn btn-sm btn-warning">
                        <i class="typcn typcn-edit me-1"></i>
                        Edit
                    </a>

                    <a href="<?= base_url('sekolah/berita/delete/' . $row['id']) ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Hapus berita ini?')">
                        <i class="typcn typcn-trash me-1"></i>
                        Hapus
                    </a>
                </div>

            </div>
        </div>
    <?php endforeach ?>

</div>

<?= $this->endSection() ?>

<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-group-outline me-2 text-primary"></i>
            Manajemen Ekstrakurikuler
        </h4>

        <a href="<?= base_url('sekolah/ekstrakurikuler/create') ?>"
            class="btn btn-primary btn-sm">
            <i class="typcn typcn-plus-outline me-1"></i>
            Tambah Ekstrakurikuler
        </a>
    </div>

    <!-- ================= ALERT ================= -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <!-- ================= TABLE ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">#</th>
                            <th style="width:90px">Gambar</th>
                            <th>Nama</th>
                            <th>Pembina</th>
                            <th>Jadwal</th>
                            <th>Tempat</th>
                            <th style="width:120px">Status</th>
                            <th style="width:180px" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($ekskul)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data Ekstrakurikuler
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($ekskul as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td>
                                    <?php if (!empty($row['gambar'])): ?>
                                        <img src="<?= base_url('uploads/ekstrakurikuler/' . session()->get('sekolah_id') . '/' . $row['gambar']) ?>"
                                            width="60"
                                            class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-semibold">
                                    <?= esc($row['nama']) ?>
                                </td>

                                <td><?= esc($row['pembina']) ?></td>
                                <td><?= esc($row['jadwal']) ?></td>
                                <td><?= esc($row['tempat']) ?></td>

                                <td>
                                    <?php if ($row['status'] === 'publish'): ?>
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">
                                            Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">

                                        <a href="<?= base_url('sekolah/ekstrakurikuler/edit/' . $row['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="typcn typcn-edit me-1"></i>
                                            Edit
                                        </a>

                                        <a href="<?= base_url('sekolah/ekstrakurikuler/delete/' . $row['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus ekstrakurikuler ini?')">
                                            <i class="typcn typcn-trash me-1"></i>
                                            Hapus
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
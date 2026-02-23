<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-clipboard me-2 text-primary"></i>
            Manajemen PPDB
        </h4>

        <div class="d-flex gap-2">
            <a href="<?= base_url('sekolah/ppdb/pendaftar') ?>"
                class="btn btn-info btn-sm">
                <i class="typcn typcn-group me-1"></i>
                Lihat Pendaftar
            </a>

            <a href="<?= base_url('sekolah/ppdb/create') ?>"
                class="btn btn-primary btn-sm">
                <i class="typcn typcn-plus-outline me-1"></i>
                Tambah PPDB
            </a>
        </div>
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
                            <th>Judul</th>
                            <th>Tahun Ajaran</th>
                            <th style="width:140px">Status</th>
                            <th style="width:180px" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($ppdb)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data PPDB
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($ppdb as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($row['judul']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= date('d M Y', strtotime($row['tanggal_mulai'])) ?>
                                        -
                                        <?= date('d M Y', strtotime($row['tanggal_selesai'])) ?>
                                    </small>
                                </td>

                                <td>
                                    <?= esc($row['tahun_ajaran']) ?>
                                </td>

                                <td>
                                    <?php if ($row['status'] === 'buka'): ?>
                                        <span class="badge bg-success">
                                            Dibuka
                                        </span>
                                    <?php elseif ($row['status'] === 'draft'): ?>
                                        <span class="badge bg-secondary">
                                            Draft
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">
                                            Ditutup
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">

                                        <a href="<?= base_url('sekolah/ppdb/edit/' . $row['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="typcn typcn-edit me-1"></i>
                                            Edit
                                        </a>

                                        <a href="<?= base_url('sekolah/ppdb/delete/' . $row['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus data PPDB ini?')">
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
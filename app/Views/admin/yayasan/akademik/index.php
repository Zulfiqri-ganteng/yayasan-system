<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <!-- <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-mortar-board me-2 text-primary"></i>
        Akademik Yayasan
    </h4> -->

    <a href="<?= base_url('admin/yayasan/akademik/create') ?>" class="btn btn-primary">
        <i class="typcn typcn-plus-outline me-1"></i>
        Tambah Akademik
    </a>
</div>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card d-none d-md-block">
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Jenjang</th>
                    <th>Nama Sekolah</th>
                    <th>Kepala Sekolah</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($akademik)) : ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                            Belum ada data akademik
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($akademik as $i => $row) : ?>
                    <tr>
                        <td><?= $i + 1 ?></td>

                        <td>
                            <span class="badge bg-info text-uppercase">
                                <?= esc($row['jenjang']) ?>
                            </span>
                        </td>

                        <td class="fw-semibold"><?= esc($row['nama_sekolah']) ?></td>
                        <td><?= esc($row['nama_kepsek']) ?></td>

                        <td>
                            <?php if ($row['status'] === 'aktif') : ?>
                                <span class="badge bg-success">
                                    <i class="typcn typcn-tick me-1"></i> Aktif
                                </span>
                            <?php else : ?>
                                <span class="badge bg-secondary">
                                    <i class="typcn typcn-times me-1"></i> Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?= base_url('admin/yayasan/akademik/edit/' . $row['id']) ?>"
                                class="btn btn-sm btn-warning me-1">
                                <i class="typcn typcn-edit"></i>
                            </a>

                            <form action="<?= base_url('admin/yayasan/akademik/delete/' . $row['id']) ?>"
                                method="post"
                                class="d-inline"
                                onsubmit="return confirm('Yakin hapus data ini?')">
                                <?= csrf_field() ?>
                                <button class="btn btn-sm btn-danger">
                                    <i class="typcn typcn-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">
    <?php if (empty($akademik)) : ?>
        <div class="card">
            <div class="card-body text-center text-muted">
                <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                Belum ada data akademik
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($akademik as $row) : ?>
        <div class="card mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-info text-uppercase">
                        <?= esc($row['jenjang']) ?>
                    </span>

                    <?php if ($row['status'] === 'aktif') : ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else : ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php endif; ?>
                </div>

                <h6 class="fw-bold mb-1">
                    <i class="typcn typcn-home-outline me-1"></i>
                    <?= esc($row['nama_sekolah']) ?>
                </h6>

                <p class="mb-2 text-muted">
                    <i class="typcn typcn-user-outline me-1"></i>
                    <?= esc($row['nama_kepsek']) ?>
                </p>

                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/yayasan/akademik/edit/' . $row['id']) ?>"
                        class="btn btn-sm btn-warning flex-fill">
                        <i class="typcn typcn-edit me-1"></i> Edit
                    </a>

                    <form action="<?= base_url('admin/yayasan/akademik/delete/' . $row['id']) ?>"
                        method="post"
                        class="flex-fill"
                        onsubmit="return confirm('Yakin hapus data ini?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-danger w-100">
                            <i class="typcn typcn-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
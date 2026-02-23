<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="typcn typcn-user-add me-2 text-primary"></i>
            Data Pendaftar PPDB
        </h4>
        <div class="d-flex justify-content-end gap-2 mb-3">

            <!-- <a href="<?= base_url('sekolah/ppdb/pendaftar/print') ?>"
                target="_blank"
                class="btn btn-outline-dark btn-sm">
                <i class="typcn typcn-printer me-1"></i> Print
            </a> -->

            <a href="<?= base_url('sekolah/ppdb/pendaftar/pdf') ?>"
                target="_blank"
                class="btn btn-danger btn-sm">
                <i class="typcn typcn-document-text me-1"></i> Export PDF
            </a>

        </div>

    

    </div>

    <!-- ================= SUMMARY CARD ================= -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <h6 class="text-muted mb-1">Total</h6>
                <h4 class="fw-bold"><?= count($pendaftar) ?></h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <h6 class="text-warning mb-1">Pending</h6>
                <h4 class="fw-bold">
                    <?= count(array_filter($pendaftar, fn($r) => $r['status'] === 'pending')) ?>
                </h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <h6 class="text-success mb-1">Diterima</h6>
                <h4 class="fw-bold">
                    <?= count(array_filter($pendaftar, fn($r) => $r['status'] === 'diterima')) ?>
                </h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <h6 class="text-danger mb-1">Ditolak</h6>
                <h4 class="fw-bold">
                    <?= count(array_filter($pendaftar, fn($r) => $r['status'] === 'ditolak')) ?>
                </h4>
            </div>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Asal Sekolah</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (empty($pendaftar)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="typcn typcn-folder-open fs-3 d-block mb-2"></i>
                                        Belum ada pendaftar
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($pendaftar as $i => $row) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td class="fw-semibold"><?= esc($row['nama_lengkap']) ?></td>
                                <td><?= esc($row['nisn']) ?></td>
                                <td><?= esc($row['asal_sekolah']) ?></td>
                                <td><?= esc($row['no_hp']) ?></td>

                                <!-- STATUS -->
                                <td>
                                    <?php
                                    $badge = match ($row['status']) {
                                        'pending'  => 'bg-warning',
                                        'diterima' => 'bg-success',
                                        'ditolak'  => 'bg-danger',
                                        default    => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badge ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>

                                <!-- AKSI -->
                                <td class="text-center">

                                    <?php if ($row['status'] === 'pending') : ?>

                                        <a href="<?= base_url('sekolah/ppdb/pendaftar/status/' . $row['id'] . '/diterima') ?>"
                                            class="btn btn-sm btn-success me-1"
                                            onclick="return confirm('Yakin ingin menerima pendaftar ini?')">
                                            Terima
                                        </a>

                                        <a href="<?= base_url('sekolah/ppdb/pendaftar/status/' . $row['id'] . '/ditolak') ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menolak pendaftar ini?')">
                                            Tolak
                                        </a>

                                    <?php else: ?>
                                        <span class="text-muted small">
                                            Sudah diproses
                                        </span>
                                    <?php endif; ?>

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
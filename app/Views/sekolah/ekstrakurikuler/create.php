<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-plus-outline me-2 text-primary"></i>
            Tambah Ekstrakurikuler
        </h4>

        <a href="<?= base_url('sekolah/ekstrakurikuler') ?>"
            class="btn btn-secondary btn-sm">
            <i class="typcn typcn-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <!-- ================= ALERT ================= -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <!-- ================= FORM ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="<?= base_url('sekolah/ekstrakurikuler/store') ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Ekstrakurikuler</label>
                        <input type="text" name="nama"
                            class="form-control"
                            value="<?= old('nama') ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pembina</label>
                        <input type="text" name="pembina"
                            class="form-control"
                            value="<?= old('pembina') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jadwal</label>
                        <input type="text" name="jadwal"
                            class="form-control"
                            value="<?= old('jadwal') ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat</label>
                        <input type="text" name="tempat"
                            class="form-control"
                            value="<?= old('tempat') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="form-control"
                        rows="4"
                        required><?= old('deskripsi') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="publish">Aktif</option>
                        <option value="draft">Nonaktif</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar"
                        class="form-control"
                        required>
                </div>

                <button class="btn btn-success">
                    <i class="typcn typcn-tick me-1"></i>
                    Simpan
                </button>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
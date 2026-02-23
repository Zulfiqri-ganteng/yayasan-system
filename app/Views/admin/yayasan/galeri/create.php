<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-image-outline text-primary me-2"></i>
        Tambah Galeri Yayasan
    </h4>

    <a href="<?= base_url('admin/yayasan/galeri') ?>"
     class="btn btn-outline-secondary">
    <i class="typcn typcn-arrow-back-outline me-1"></i>
    Kembali
  </a>
</div> -->

<!-- ================= ALERT ERROR ================= -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center mb-1">
            <i class="typcn typcn-warning-outline me-1"></i>
            <strong>Terjadi Kesalahan</strong>
        </div>
        <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif ?>

<!-- ================= FORM ================= -->
<form action="<?= base_url('admin/yayasan/galeri/store') ?>"
    method="post"
    enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row g-3">

                <!-- JUDUL -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-document-text me-1 text-primary"></i>
                        Judul Galeri
                    </label>
                    <input type="text"
                        name="judul"
                        class="form-control"
                        placeholder="Masukkan judul galeri"
                        required>
                </div>

                <!-- GAMBAR -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-upload-outline me-1 text-primary"></i>
                        Gambar Galeri
                    </label>
                    <input type="file"
                        name="gambar"
                        class="form-control"
                        accept="image/*"
                        required>
                    <small class="text-muted">
                        Format JPG / PNG, disarankan resolusi landscape
                    </small>
                </div>

            </div>

        </div>

        <!-- ================= ACTION ================= -->
        <div class="card-footer bg-light d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="typcn typcn-tick-outline me-1"></i>
                Simpan
            </button>

            <a href="<?= base_url('admin/yayasan/galeri') ?>"
                class="btn btn-outline-secondary px-4">
                <i class="typcn typcn-arrow-back-outline me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
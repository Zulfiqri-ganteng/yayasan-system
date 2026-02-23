<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <!-- <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0 d-flex align-items-center">
            <i class="typcn typcn-info-large-outline text-primary me-2"></i>
            Tentang Sekolah
        </h4>

        <span class="text-muted small">
            CMS Website Sekolah
        </span>
    </div> -->

    <!-- ================= ALERT ================= -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <!-- ================= FORM CARD ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('sekolah/tentang/save') ?>"
                enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- JUDUL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-document-text me-1 text-muted"></i>
                        Judul Halaman
                    </label>
                    <input type="text"
                        name="judul"
                        class="form-control"
                        value="<?= esc($data['judul'] ?? 'Tentang Sekolah') ?>">
                </div>

                <!-- KONTEN -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-edit me-1 text-muted"></i>
                        Konten Tentang Sekolah
                    </label>
                    <textarea name="konten"
                        rows="8"
                        class="form-control"
                        placeholder="Tuliskan profil singkat sekolah..."><?= esc($data['konten'] ?? '') ?></textarea>
                    <small class="text-muted">
                        Konten ini akan ditampilkan pada halaman publik Tentang Sekolah.
                    </small>
                </div>

                <hr class="my-4">

                <!-- BANNER -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-image-outline me-1 text-muted"></i>
                        Banner Tentang Sekolah
                    </label>
                    <input type="file"
                        name="banner_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <?php if (!empty($data['banner_image'])): ?>
                        <div class="mt-3">
                            <img src="<?= base_url('uploads/sekolah/' . $data['banner_image']) ?>"
                                class="img-fluid rounded shadow-sm"
                                style="max-height:260px">
                        </div>
                    <?php endif ?>
                </div>

                <!-- ACTION -->
                <div class="mt-4 text-end">
                    <button class="btn btn-primary px-4">
                        <i class="typcn typcn-tick-outline me-1"></i>
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
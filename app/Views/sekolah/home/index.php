<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="d-flex align-items-center mb-4">
        <i class="fa fa-home text-primary me-2 fs-4"></i>
        <h4 class="mb-0 fw-semibold">CMS Beranda Sekolah</h4>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-1"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">
            <i class="fa fa-image me-1 text-primary"></i>
            Hero / Slider Beranda
        </div>

        <div class="card-body">

            <form action="<?= base_url('sekolah/home/simpan') ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- HERO TITLE -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-heading me-1"></i> Hero Title
                    </label>
                    <input type="text"
                        name="hero_title"
                        class="form-control"
                        value="<?= esc($home['hero_title'] ?? '') ?>">
                </div>

                <!-- HERO SUBTITLE -->
                <!-- <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-align-left me-1"></i> Hero Subtitle
                    </label>
                    <textarea name="hero_subtitle"
                        rows="3"
                        class="form-control"><?= esc($home['hero_subtitle'] ?? '') ?></textarea>
                </div> -->

                <hr>

                <!-- HERO IMAGES -->
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <?php $field = 'hero_image_' . $i; ?>
                    <div class="row mb-4 align-items-center">

                        <!-- UPLOAD -->
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">
                                <i class="fa fa-image me-1"></i>
                                Hero Image <?= $i ?>
                            </label>
                            <input type="file"
                                name="<?= $field ?>"
                                class="form-control">
                            <small class="text-muted">JPG / PNG • Max 2MB</small>

                            <?php if (!empty($home[$field])): ?>
                                <div class="form-check mt-2">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="delete_<?= $field ?>"
                                        value="1"
                                        id="delete_<?= $field ?>">
                                    <label class="form-check-label text-danger"
                                        for="delete_<?= $field ?>">
                                        Hapus gambar ini
                                    </label>
                                </div>
                            <?php endif ?>
                        </div>

                        <!-- PREVIEW -->
                        <div class="col-md-7">
                            <?php if (!empty($home[$field])): ?>
                                <div class="border rounded p-2 text-center bg-light">
                                    <small class="text-muted d-block mb-1">Preview</small>
                                    <img src="<?= base_url('uploads/home/' . $home[$field]) ?>"
                                        class="img-fluid rounded shadow-sm"
                                        style="max-height:160px">
                                </div>
                            <?php else: ?>
                                <div class="text-muted fst-italic mt-4">
                                    Belum ada gambar
                                </div>
                            <?php endif ?>
                        </div>

                    </div>
                <?php endfor ?>

                <!-- ACTION -->
                <div class="text-end">
                    <button class="btn btn-primary px-4">
                        <i class="fa fa-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
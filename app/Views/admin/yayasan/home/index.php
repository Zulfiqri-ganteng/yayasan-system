<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex align-items-center mb-4">
  <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-home-outline text-primary me-2"></i>
    CMS Beranda Yayasan
  </h4>
</div> -->

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('admin/yayasan/home/save') ?>"
  method="post"
  enctype="multipart/form-data">
  <?= csrf_field() ?>

  <!-- ================= HERO TEXT ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-folder-open me-2"></i>
        Hero Section
      </h5>
    </div>

    <div class="card-body">

      <!-- HERO TITLE -->
      <div class="mb-3">
        <label class="form-label fw-semibold d-flex align-items-center">
          <i class="typcn typcn-edit me-1 text-primary"></i>
          Hero Title
        </label>
        <input type="text"
          name="hero_title"
          class="form-control"
          placeholder="Judul utama beranda pada slider"
          value="<?= esc($home['hero_title'] ?? '') ?>">
      </div>

      <!-- HERO SUBTITLE -->
      <!-- <div class="mb-3">
        <label class="form-label fw-semibold d-flex align-items-center">
          <i class="typcn typcn-document-text me-1 text-primary"></i>
          Hero Subtitle
        </label>
        <textarea name="hero_subtitle"
          rows="3"
          class="form-control"
          placeholder="Subjudul / deskripsi singkat"><?= esc($home['hero_subtitle'] ?? '') ?></textarea>
      </div> -->

    </div>
  </div>

  <!-- ================= HERO SLIDER ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-image-outline text-primary me-2"></i>
        Hero Images (Slider)
      </h5>
    </div>

    <div class="card-body">
      <div class="row g-3">

        <?php for ($i = 1; $i <= 6; $i++): ?>
          <div class="col-lg-4 col-md-6 col-12">
            <label class="form-label fw-semibold">
              Hero Image <?= $i ?>
            </label>

            <input type="file"
              name="hero_image<?= $i ?>"
              class="form-control">

            <?php if (!empty($home['hero_image' . $i])): ?>
              <div class="mt-2">
                <img src="<?= base_url('uploads/hero/' . $home['hero_image' . $i]) ?>"
                  class="img-fluid rounded border"
                  style="max-height:160px;">
              </div>
            <?php endif ?>
          </div>
        <?php endfor ?>

      </div>
    </div>
  </div>

  <!-- ================= ACTION ================= -->
  <div class="d-flex justify-content-end">
    <button class="btn btn-primary px-4">
      <i class="typcn typcn-save-outline me-1"></i>
      Simpan Beranda
    </button>
  </div>

</form>

<?= $this->endSection() ?>
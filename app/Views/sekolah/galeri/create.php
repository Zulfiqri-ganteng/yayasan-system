<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- ================= HEADER ================= -->
  <!-- <div class="mb-4">
    <h4 class="fw-bold d-flex align-items-center mb-1">
      <i class="typcn typcn-image-outline text-primary me-2"></i>
      Tambah Galeri Sekolah
    </h4>
    <span class="text-muted small">
      CMS Website Sekolah
    </span>
  </div> -->

  <!-- ================= FORM CARD ================= -->
  <div class="card shadow-sm border-0">
    <div class="card-body">

      <form action="<?= base_url('sekolah/galeri/store') ?>"
        method="post"
        enctype="multipart/form-data">

        <?= csrf_field() ?>

        <!-- JUDUL -->
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Judul Foto
          </label>
          <input type="text"
            name="judul"
            class="form-control"
            placeholder="Contoh: Kegiatan Upacara Bendera"
            required>
        </div>

        <!-- GAMBAR -->
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Foto Galeri
          </label>
          <input type="file"
            name="gambar"
            class="form-control"
            accept="image/*"
            required>

          <small class="text-muted d-block mt-1">
            Maksimal 2MB · JPG, PNG, JPEG, WEBP (aman untuk iPhone)
          </small>
        </div>

        <!-- ACTION -->
        <div class="d-flex gap-2 mt-4 flex-wrap">
          <button class="btn btn-primary px-4">
            <i class="typcn typcn-save me-1"></i>
            Simpan
          </button>

          <a href="<?= base_url('sekolah/galeri') ?>"
            class="btn btn-secondary px-4">
            <i class="typcn typcn-arrow-back-outline me-1"></i>
            Kembali
          </a>
        </div>

      </form>

    </div>
  </div>

</div>

<?= $this->endSection() ?>
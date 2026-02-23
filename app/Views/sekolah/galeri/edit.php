<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- PAGE HEADER -->
  <!-- <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
      <h4 class="fw-bold mb-0">
        <i class="typcn typcn-image-outline text-primary me-2"></i>
        Edit Galeri Sekolah
      </h4>
      <small class="text-muted">CMS Website Sekolah</small>
    </div>

    <a href="<?= base_url('sekolah/galeri') ?>" class="btn btn-light btn-sm">
      <i class="typcn typcn-arrow-back-outline me-1"></i>
      Kembali
    </a>
  </div> -->

  <!-- ALERT ERROR -->
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <?= session()->getFlashdata('error') ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif ?>

  <!-- FORM CARD -->
  <div class="card shadow-sm border-0">
    <div class="card-body">

      <form action="<?= base_url('sekolah/galeri/update/' . $row['id']) ?>"
        method="post"
        enctype="multipart/form-data">

        <?= csrf_field() ?>

        <!-- JUDUL -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Judul Foto</label>
          <input type="text"
            name="judul"
            class="form-control"
            value="<?= esc($row['judul']) ?>"
            required>
        </div>

        <!-- FOTO SAAT INI -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Foto Saat Ini</label><br>

          <?php if (!empty($row['gambar'])): ?>
            <img src="<?= base_url('uploads/sekolah/galeri/' . $row['gambar']) ?>"
              class="rounded shadow-sm mb-2"
              style="width:220px; height:140px; object-fit:cover;">
          <?php else: ?>
            <div class="text-muted fst-italic">
              Tidak ada gambar
            </div>
          <?php endif ?>
        </div>

        <!-- GANTI FOTO -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Ganti Foto (Opsional)</label>
          <input type="file"
            name="gambar"
            class="form-control"
            accept="image/*">
          <small class="text-muted">
            Jika diunggah, foto lama akan otomatis dihapus · Maks 2MB · JPG, PNG, WEBP
          </small>
        </div>

        <!-- ACTION -->
        <div class="mt-4 d-flex gap-2 flex-wrap">
          <button class="btn btn-primary px-4">
            <i class="typcn typcn-save me-1"></i>
            Update
          </button>

          <a href="<?= base_url('sekolah/galeri') ?>" class="btn btn-secondary px-4">
            Batal
          </a>
        </div>

      </form>

    </div>
  </div>

</div>

<?= $this->endSection() ?>
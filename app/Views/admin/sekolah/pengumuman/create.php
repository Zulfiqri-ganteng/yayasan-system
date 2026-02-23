<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- ================= HEADER ================= -->
  <!-- <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
      <i class="typcn typcn-megaphone-outline text-primary me-2"></i>
      Tambah Pengumuman
    </h4>

    <a href="<?= base_url('sekolah/pengumuman') ?>" class="btn btn-secondary">
      <i class="typcn typcn-arrow-left-outline me-1"></i>
      Kembali
    </a>
  </div> -->

  <!-- ================= ALERT ERROR ================= -->
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <ul class="mb-0">
        <?php foreach (session('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach ?>
      </ul>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif ?>

  <!-- ================= FORM CARD ================= -->
  <div class="card shadow-sm border-0">
    <div class="card-body">

      <form action="<?= base_url('sekolah/pengumuman/store') ?>"
            method="post"
            enctype="multipart/form-data">

        <?= csrf_field() ?>

        <!-- JUDUL -->
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Judul Pengumuman
          </label>
          <input type="text"
                 name="judul"
                 class="form-control"
                 value="<?= old('judul') ?>"
                 required>
        </div>

        <!-- ISI -->
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Isi Pengumuman
          </label>
          <textarea name="isi"
                    rows="6"
                    class="form-control"
                    required><?= old('isi') ?></textarea>
        </div>

        <!-- FILE -->
        <div class="mb-3">
          <label class="form-label fw-semibold">
            Upload Gambar / PDF
          </label>
          <input type="file"
                 name="file"
                 class="form-control">
          <small class="text-muted">
            JPG · PNG · WEBP · PDF • Maksimal 4MB
          </small>
        </div>

        <!-- STATUS -->
        <div class="mb-4">
          <label class="form-label fw-semibold">
            Status Publikasi
          </label>
          <select name="status" class="form-select">
            <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>
              Draft
            </option>
            <option value="publish" <?= old('status') === 'publish' ? 'selected' : '' ?>>
              Publish
            </option>
          </select>
        </div>

        <!-- ACTION -->
        <div class="d-flex gap-2 flex-wrap">
          <button type="submit" class="btn btn-primary px-4">
            <i class="typcn typcn-save me-1"></i>
            Simpan
          </button>

          <a href="<?= base_url('sekolah/pengumuman') ?>"
             class="btn btn-light px-4">
            <i class="typcn typcn-times me-1"></i>
            Batal
          </a>
        </div>

      </form>

    </div>
  </div>

</div>

<?= $this->endSection() ?>

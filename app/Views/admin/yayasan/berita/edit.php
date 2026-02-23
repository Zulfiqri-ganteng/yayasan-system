<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <!-- <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-document-text text-primary me-2"></i>
    Edit Berita Yayasan
  </h4> -->

  <!-- <a href="<?= base_url('admin/yayasan/berita') ?>"
     class="btn btn-outline-secondary">
    <i class="typcn typcn-arrow-back-outline me-1"></i>
    Kembali
  </a> -->
</div>

<!-- ================= FORM ================= -->
<form action="<?= base_url('admin/yayasan/berita/update/' . $data['id']) ?>"
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
            Judul Berita
          </label>
          <input type="text"
                 name="judul"
                 class="form-control"
                 value="<?= esc($data['judul']) ?>"
                 required>
        </div>

        <!-- KONTEN -->
        <div class="col-12">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-edit me-1 text-primary"></i>
            Konten Berita
          </label>
          <textarea name="konten"
                    rows="8"
                    class="form-control"
                    required><?= esc($data['konten']) ?></textarea>
        </div>

        <!-- STATUS -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-adjust-brightness me-1 text-primary"></i>
            Status
          </label>
          <select name="status" class="form-select">
            <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>
              Draft
            </option>
            <option value="publish" <?= $data['status'] === 'publish' ? 'selected' : '' ?>>
              Publish
            </option>
          </select>
        </div>

        <!-- GAMBAR -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-image-outline me-1 text-primary"></i>
            Gambar Berita
          </label>
          <input type="file"
                 name="featured_image"
                 class="form-control">

          <?php if (!empty($data['featured_image'])): ?>
            <div class="mt-2">
              <img src="<?= base_url('uploads/berita/' . $data['featured_image']) ?>"
                   class="img-thumbnail"
                   style="max-height:140px;">
            </div>
          <?php endif; ?>
        </div>

      </div>

    </div>

    <!-- ================= ACTION ================= -->
    <div class="card-footer bg-light d-flex justify-content-end gap-2">
      <button type="submit" class="btn btn-primary px-4">
        <i class="typcn typcn-tick-outline me-1"></i>
        Update
      </button>

      <a href="<?= base_url('admin/yayasan/berita') ?>"
         class="btn btn-outline-secondary px-4">
        <i class="typcn typcn-arrow-back-outline me-1"></i>
        Kembali
      </a>
    </div>

  </div>
</form>

<?= $this->endSection() ?>

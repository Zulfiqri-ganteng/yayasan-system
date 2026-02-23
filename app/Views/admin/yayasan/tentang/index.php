<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex align-items-center mb-4">
  <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-info-large-outline text-primary me-2"></i>
    Tentang Yayasan
  </h4>
</div> -->

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif ?>

<form method="post"
      action="<?= base_url('admin/yayasan/tentang/save') ?>"
      enctype="multipart/form-data">
  <?= csrf_field() ?>

  <!-- ================= PROFIL YAYASAN ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-folder-open me-2"></i>
        Profil Yayasan
      </h5>
    </div>

    <div class="card-body">

      <!-- JUDUL -->
      <div class="mb-3">
        <label class="form-label fw-semibold d-flex align-items-center">
          <i class="typcn typcn-edit me-1 text-primary"></i>
          Judul Halaman
        </label>
        <input type="text"
               name="judul"
               class="form-control"
               value="<?= esc($data['judul'] ?? 'Tentang Kami') ?>">
      </div>

      <!-- KONTEN -->
      <div class="mb-4">
        <label class="form-label fw-semibold d-flex align-items-center">
          <i class="typcn typcn-document-text me-1 text-primary"></i>
          Konten Tentang Yayasan
        </label>
        <textarea name="konten"
                  rows="8"
                  class="form-control"
                  placeholder="Tuliskan profil singkat yayasan..."><?= esc($data['konten'] ?? '') ?></textarea>
        <small class="text-muted">
          Konten ini akan tampil di halaman publik Tentang Yayasan.
        </small>
      </div>

    </div>
  </div>

  <!-- ================= BANNER ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-image-outline text-primary me-2"></i>
        Banner Tentang Yayasan
      </h5>
    </div>

    <div class="card-body">
      <input type="file" name="banner_image" class="form-control">

      <?php if (!empty($data['banner_image'])): ?>
        <div class="mt-3">
          <img src="<?= base_url('uploads/yayasan/' . $data['banner_image']) ?>"
               class="img-fluid rounded border"
               style="max-height:260px;">
        </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================= DIREKTUR ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-user-outline text-primary me-2"></i>
        Direktur Utama
      </h5>
    </div>

    <div class="card-body">
      <div class="row g-3">

        <div class="col-md-6">
          <label class="form-label fw-semibold">Nama Direktur Utama</label>
          <input type="text"
                 name="nama_direktur"
                 class="form-control"
                 value="<?= esc($data['nama_direktur'] ?? '') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Foto Direktur</label>
          <input type="file" name="foto_direktur" class="form-control">

          <?php if (!empty($data['foto_direktur'])): ?>
            <div class="mt-3">
              <img src="<?= base_url('uploads/yayasan/' . $data['foto_direktur']) ?>"
                   class="rounded-circle shadow-sm"
                   style="width:100px;height:100px;object-fit:cover;">
            </div>
          <?php endif ?>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-message-typing me-1 text-primary"></i>
            Pesan Direktur Utama
          </label>
          <textarea name="pesan_direktur"
                    rows="6"
                    class="form-control"
                    placeholder="Tulis pesan resmi Direktur Utama Yayasan..."><?= esc($data['pesan_direktur'] ?? '') ?></textarea>
          <small class="text-muted">
            Pesan ini akan ditampilkan di halaman Tentang Yayasan
          </small>
        </div>

      </div>
    </div>
  </div>

  <!-- ================= ACTION ================= -->
  <div class="d-flex justify-content-end">
    <button class="btn btn-primary px-4">
      <i class="typcn typcn-save-outline me-1"></i>
      Simpan Perubahan
    </button>
  </div>

</form>

<?= $this->endSection() ?>

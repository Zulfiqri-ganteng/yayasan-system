<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex align-items-center mb-4">
  <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-eye-outline text-primary me-2"></i>
    Visi & Misi Yayasan
  </h4>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif ?>

<form action="<?= base_url('admin/yayasan/visi-misi/save') ?>" method="post">
  <?= csrf_field() ?>

  <!-- ================= VISI ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-folder-open me-2"></i>
        Visi Yayasan
      </h5>
    </div>

    <div class="card-body">
      <label class="form-label fw-semibold d-flex align-items-center">
        <i class="typcn typcn-lightbulb me-1 text-primary"></i>
        Visi
      </label>
      <textarea name="visi"
                rows="4"
                class="form-control"
                placeholder="Tuliskan visi yayasan..."><?= esc($data['visi'] ?? '') ?></textarea>
    </div>
  </div>

  <!-- ================= MISI ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-th-list text-primary me-2"></i>
        Misi Yayasan
      </h5>
    </div>

    <div class="card-body">
      <label class="form-label fw-semibold d-flex align-items-center">
        <i class="typcn typcn-th-list me-1 text-primary"></i>
        Misi
      </label>
      <textarea name="misi"
                rows="6"
                class="form-control"
                placeholder="Tuliskan misi yayasan..."><?= esc($data['misi'] ?? '') ?></textarea>
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

<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex align-items-center mb-4">
  <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-time text-primary me-2"></i>
    Sejarah Yayasan
  </h4>
</div> -->

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<!-- ================= FORM INPUT ================= -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0 d-flex align-items-center">
      <i class="typcn typcn-folder-open me-2"></i>
      Tambah Sejarah
    </h5>
  </div>

  <div class="card-body">
    <form action="<?= base_url('admin/yayasan/sejarah/save') ?>" method="post">
      <?= csrf_field() ?>

      <div class="row g-3">

        <!-- TAHUN -->
        <div class="col-md-2">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-calendar-outline me-1 text-primary"></i>
            Tahun
          </label>
          <input type="text" name="tahun" class="form-control" required>
        </div>

        <!-- JUDUL -->
        <div class="col-md-4">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-edit me-1 text-primary"></i>
            Judul
          </label>
          <input type="text" name="judul" class="form-control" required>
        </div>

        <!-- URUTAN -->
        <div class="col-md-2">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-sort-numerically me-1 text-primary"></i>
            Urutan
          </label>
          <input type="number" name="urutan" class="form-control" value="0">
        </div>

        <!-- STATUS -->
        <div class="col-md-2">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-power-outline me-1 text-primary"></i>
            Status
          </label>
          <select name="status" class="form-select">
            <option value="1">Publish</option>
            <option value="0">Draft</option>
          </select>
        </div>

        <!-- DESKRIPSI -->
        <div class="col-12">
          <label class="form-label fw-semibold d-flex align-items-center">
            <i class="typcn typcn-document-text me-1 text-primary"></i>
            Deskripsi
          </label>
          <textarea name="deskripsi"
            rows="4"
            class="form-control"
            required></textarea>
        </div>

      </div>

      <div class="text-end mt-3">
        <button class="btn btn-primary px-4">
          <i class="typcn typcn-save-outline me-1"></i>
          Simpan Sejarah
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ================= DATA LIST ================= -->
<div class="card shadow-sm border-0">
  <div class="card-header bg-light">
    <h5 class="mb-0 d-flex align-items-center">
      <i class="typcn typcn-th-list text-primary me-2"></i>
      Daftar Sejarah
    </h5>
  </div>

  <div class="card-body table-responsive">
    <table class="table align-middle table-hover">
      <thead class="table-light">
        <tr>
          <th width="80">Tahun</th>
          <th>Judul</th>
          <th>Deskripsi</th>
          <th width="80">Urutan</th>
          <th width="100">Status</th>
          <th width="90">Aksi</th>
        </tr>
      </thead>
      <tbody>

        <?php if (empty($data)): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              <i class="typcn typcn-info-large-outline d-block mb-2"></i>
              Belum ada data sejarah
            </td>
          </tr>
        <?php endif; ?>

        <?php foreach ($data as $row): ?>
          <tr>
            <td><?= esc($row['tahun']) ?></td>
            <td class="fw-semibold"><?= esc($row['judul']) ?></td>
            <td><?= esc($row['deskripsi']) ?></td>
            <td><?= esc($row['urutan']) ?></td>
            <td>
              <?= $row['status']
                ? '<span class="badge bg-success">Publish</span>'
                : '<span class="badge bg-secondary">Draft</span>' ?>
            </td>
            <td>
              <a href="<?= base_url('admin/yayasan/sejarah/delete/' . $row['id']) ?>"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Hapus data ini?')">
                <i class="typcn typcn-trash me-1"></i>
                Hapus
              </a>
            </td>
          </tr>
        <?php endforeach ?>

      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
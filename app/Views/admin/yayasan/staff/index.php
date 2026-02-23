<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <!-- <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-group-outline text-primary me-2"></i>
    Staff Yayasan
  </h4> -->

  <a href="<?= base_url('admin/yayasan/staff/create') ?>"
    class="btn btn-primary">
    <i class="typcn typcn-plus-outline me-1"></i>
    Tambah Staff
  </a>
</div>

<!-- ================= GRID STAFF ================= -->
<div class="row g-4">

  <?php if (empty($staff)): ?>
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center text-muted py-5">
          <i class="typcn typcn-info-large-outline d-block mb-2"></i>
          Belum ada data staff yayasan
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php foreach ($staff as $s): ?>
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
      <div class="card shadow-sm border-0 h-100 text-center">

        <!-- FOTO -->
        <img src="<?= base_url('uploads/staff/' . ($s['foto'] ?? 'default.png')) ?>"
          class="card-img-top"
          style="height:200px;object-fit:cover">

        <div class="card-body d-flex flex-column">

          <!-- NAMA -->
          <h6 class="fw-bold mb-1 d-flex justify-content-center align-items-center">
            <i class="typcn typcn-user-outline me-1 text-primary"></i>
            <?= esc($s['nama']) ?>
          </h6>

          <!-- JABATAN -->
          <small class="text-muted d-flex justify-content-center align-items-center mb-3">
            <i class="typcn typcn-briefcase me-1"></i>
            <?= esc($s['jabatan']) ?>
          </small>

          <!-- AKSI -->
          <div class="mt-auto d-grid gap-2">
            <!-- EDIT (BELUM AKTIF) -->
            <a href="<?= base_url('admin/yayasan/staff/edit/' . $s['id']) ?>"
              class="btn btn-sm btn-warning">
              <i class="typcn typcn-edit me-1"></i>
              Edit
            </a>


            <!-- HAPUS -->
            <a href="<?= base_url('admin/yayasan/staff/delete/' . $s['id']) ?>"
              onclick="return confirm('Hapus data staff ini?')"
              class="btn btn-sm btn-danger">
              <i class="typcn typcn-trash me-1"></i>
              Hapus
            </a>
          </div>

        </div>
      </div>
    </div>
  <?php endforeach ?>

</div>

<?= $this->endSection() ?>
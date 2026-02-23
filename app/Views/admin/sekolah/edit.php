<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->


<!-- ================= FORM ================= -->
<form method="post"
      action="<?= base_url('admin/sekolah/update/' . $sekolah['id']) ?>">
  <?= csrf_field() ?>

  <div class="card shadow-sm border-0">
    <div class="card-body">

      <div class="row g-3">

        <!-- NAMA SEKOLAH -->
        <div class="col-12">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-home-outline me-1 text-primary"></i>
            Nama Sekolah
          </label>
          <input type="text"
                 name="nama_sekolah"
                 class="form-control"
                 value="<?= esc($sekolah['nama_sekolah']) ?>"
                 required>
        </div>

        <!-- JENJANG -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-flow-children me-1 text-primary"></i>
            Jenjang
          </label>
          <select name="jenjang" class="form-select" required>
            <option value="tk"  <?= $sekolah['jenjang'] === 'tk'  ? 'selected' : '' ?>>TK</option>
            <option value="sd"  <?= $sekolah['jenjang'] === 'sd'  ? 'selected' : '' ?>>SD</option>
            <option value="smp" <?= $sekolah['jenjang'] === 'smp' ? 'selected' : '' ?>>SMP</option>
            <option value="sma" <?= $sekolah['jenjang'] === 'sma' ? 'selected' : '' ?>>SMA</option>
            <option value="smk" <?= $sekolah['jenjang'] === 'smk' ? 'selected' : '' ?>>SMK</option>
          </select>
        </div>

      </div>

    </div>

    <!-- ================= ACTION ================= -->
    <div class="card-footer bg-light d-flex justify-content-end gap-2">
      <button type="submit" class="btn btn-primary px-4">
        <i class="typcn typcn-tick-outline me-1"></i>
        Simpan Perubahan
      </button>

      <a href="<?= base_url('admin/sekolah') ?>"
         class="btn btn-outline-secondary px-4">
        <i class="typcn typcn-arrow-back-outline me-1"></i>
        Kembali
      </a>
    </div>
  </div>
</form>

<?= $this->endSection() ?>

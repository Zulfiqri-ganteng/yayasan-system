<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- ================= HEADER ================= -->
  <!-- <div class="d-flex align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center">
      <i class="typcn typcn-plus-outline text-primary me-2"></i>
      Tambah Fitur Sistem
    </h4>
  </div> -->

  <!-- ================= CARD ================= -->
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-6">

      <div class="card shadow-sm border-0">
        <div class="card-body">

          <!-- ALERT -->
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <?= session()->getFlashdata('error') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('admin/fitur/store') ?>">
            <?= csrf_field() ?>

            <!-- KODE FITUR -->
            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="typcn typcn-code-outline me-1 text-muted"></i>
                Kode Fitur
              </label>
              <input type="text"
                name="kode"
                class="form-control"
                placeholder="contoh: jadwal_pelajaran"
                value="<?= old('kode') ?>"
                required>
              <small class="text-muted">
                Gunakan huruf kecil, tanpa spasi, dan underscore (_)
              </small>
            </div>

            <!-- NAMA FITUR -->
            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="typcn typcn-tag me-1 text-muted"></i>
                Nama Fitur
              </label>
              <input type="text"
                name="nama"
                class="form-control"
                placeholder="Contoh: Jadwal Pelajaran"
                value="<?= old('nama') ?>"
                required>
            </div>

            <!-- KATEGORI -->
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="typcn typcn-folder-open me-1 text-muted"></i>
                Kategori
              </label>
              <select name="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="akademik" <?= old('kategori') == 'akademik' ? 'selected' : '' ?>>Akademik</option>
                <option value="keuangan" <?= old('kategori') == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                <option value="absensi" <?= old('kategori') == 'absensi' ? 'selected' : '' ?>>Absensi</option>
                <option value="cms" <?= old('kategori') == 'cms' ? 'selected' : '' ?>>CMS Website</option>
                <option value="master" <?= old('kategori') == 'master' ? 'selected' : '' ?>>Master Data</option>
              </select>
            </div>

            <!-- ACTION -->
            <div class="d-flex gap-2 flex-wrap justify-content-end">
              <a href="<?= base_url('admin/fitur') ?>"
                class="btn btn-secondary">
                <i class="typcn typcn-arrow-left-outline me-1"></i>
                Kembali
              </a>

              <button class="btn btn-primary">
                <i class="typcn typcn-tick-outline me-1"></i>
                Simpan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>

</div>

<?= $this->endSection() ?>
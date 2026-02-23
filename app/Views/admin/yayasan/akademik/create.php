<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex align-items-center mb-4">
  <h4 class="mb-0 d-flex align-items-center">
    <i class="typcn typcn-plus-outline text-primary me-2"></i>
    Tambah Akademik
  </h4>
</div> -->

<form action="<?= base_url('admin/yayasan/akademik/store') ?>"
      method="post"
      enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="card shadow-sm border-0">
    <div class="card-body">

      <div class="row g-3">

        <!-- JENJANG -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-mortar-board me-1"></i>
            Jenjang
          </label>
          <select name="jenjang" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="kbtk">KB / TK</option>
            <option value="sd">SD</option>
            <option value="smp">SMP</option>
            <option value="sma">SMA</option>
            <option value="smk">SMK</option>
          </select>
        </div>

        <!-- NAMA SEKOLAH -->
        <div class="col-md-8">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-home-outline me-1"></i>
            Nama Sekolah
          </label>
          <input type="text"
                 name="nama_sekolah"
                 class="form-control"
                 placeholder="Contoh: SMK Galajuara"
                 required>
        </div>

        <!-- DESKRIPSI -->
        <div class="col-12">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-document-text me-1"></i>
            Deskripsi
          </label>
          <textarea name="deskripsi"
                    rows="4"
                    class="form-control"
                    placeholder="Deskripsi singkat sekolah"></textarea>
        </div>

        <!-- KEPALA SEKOLAH -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-user-outline me-1"></i>
            Nama Kepala Sekolah
          </label>
          <input type="text"
                 name="nama_kepsek"
                 class="form-control"
                 placeholder="Nama kepala sekolah">
        </div>

        <!-- FOTO SEKOLAH -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-image-outline me-1"></i>
            Foto Sekolah
          </label>
          <input type="file"
                 name="foto_sekolah"
                 class="form-control">
        </div>

        <!-- FOTO KEPALA SEKOLAH -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-camera-outline me-1"></i>
            Foto Kepala Sekolah
          </label>
          <input type="file"
                 name="foto_kepsek"
                 class="form-control">
        </div>

        <!-- URUTAN -->
        <div class="col-md-3">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-sort-numerically me-1"></i>
            Urutan
          </label>
          <input type="number"
                 name="urutan"
                 class="form-control"
                 value="0">
        </div>

      </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <div class="card-footer bg-light d-flex justify-content-between">
      <a href="<?= base_url('admin/yayasan/akademik') ?>"
         class="btn btn-secondary">
        <i class="typcn typcn-arrow-left me-1"></i>
        Kembali
      </a>

      <button type="submit"
              class="btn btn-primary">
        <i class="typcn typcn-tick-outline me-1"></i>
        Simpan Akademik
      </button>
    </div>
  </div>

</form>

<?= $this->endSection() ?>

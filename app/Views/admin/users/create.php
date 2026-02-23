<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->


<!-- ================= FORM CARD ================= -->
<div class="card shadow-sm border-0">
  <div class="card-body">

    <form method="post" action="<?= base_url('admin/users/store') ?>">
      <?= csrf_field() ?>

      <div class="row g-3">

        <!-- SEKOLAH -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-home-outline me-1 text-muted"></i>
            Sekolah
          </label>
          <select name="sekolah_id"
            class="form-select"
            required>
            <option value="">-- Pilih Sekolah --</option>
            <?php foreach ($sekolah as $s): ?>
              <?php if (strtolower($s['jenjang']) !== 'yayasan'): ?>
                <option value="<?= $s['id'] ?>">
                  <?= esc($s['nama_sekolah']) ?>
                </option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>

        <!-- USERNAME -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-user me-1 text-muted"></i>
            Username
          </label>
          <input type="text"
            name="username"
            class="form-control"
            placeholder="contoh: smkgalajuara"
            required>
        </div>
        <!-- EMAIL -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-mail me-1 text-muted"></i>
            Email
          </label>
          <input type="email"
            name="email"
            class="form-control"
            placeholder="admin@sekolah.com"
            required>
        </div>

        <!-- PASSWORD -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
            <i class="typcn typcn-lock-closed-outline me-1 text-muted"></i>
            Password
          </label>
          <input type="password"
            name="password"
            class="form-control"
            required>
          <small class="text-muted">
            Password awal biasanya disamakan dengan username
          </small>
        </div>

      </div>

      <!-- ACTION -->
      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="<?= base_url('admin/users') ?>"
          class="btn btn-secondary">
          <i class="typcn typcn-arrow-back-outline me-1"></i>
          Kembali
        </a>

        <button type="submit"
          class="btn btn-primary">
          <i class="typcn typcn-save me-1"></i>
          Simpan Admin
        </button>
      </div>

    </form>

  </div>
</div>

<?= $this->endSection() ?>
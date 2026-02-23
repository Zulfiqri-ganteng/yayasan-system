<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <?= $this->include('admin/partials/breadcrumb') ?>

  <!-- ================= ALERT ================= -->
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- ================= PROFIL SEKOLAH ================= -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-home-outline me-2"></i>
        Profil Sekolah
      </h4>
    </div>

    <div class="card-body">
      <form method="post"
        action="<?= base_url('sekolah/profil/simpan') ?>"
        enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3">

          <!-- DATA UTAMA -->
          <div class="col-lg-8">

            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Sekolah</label>
                <input type="text" name="nama_sekolah"
                  class="form-control"
                  value="<?= esc($profil['nama_sekolah'] ?? '') ?>" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-semibold">NPSN</label>
                <input type="text" name="npsn"
                  class="form-control"
                  value="<?= esc($profil['npsn'] ?? '') ?>">
              </div>
            </div>
            <!-- GOOGLE MAPS -->
            <div class="mt-3">
              <label class="form-label fw-semibold">
                Google Maps (Embed Link)
              </label>

              <textarea name="google_maps"
                class="form-control"
                rows="3"
                placeholder="Tempelkan link embed Google Maps (src saja)..."><?= esc($profil['google_maps'] ?? '') ?></textarea>

              <small class="text-muted">
                Buka Google Maps → Share → Embed a map → Copy link pada bagian src.
                Contoh: https://www.google.com/maps/embed?pb=....
              </small>
            </div>

            <div class="mt-3">
              <label class="form-label fw-semibold">Alamat Sekolah</label>
              <textarea name="alamat"
                class="form-control"
                rows="2"><?= esc($profil['alamat'] ?? '') ?></textarea>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Desa / Kelurahan</label>
                <input type="text" name="desa" class="form-control"
                  value="<?= esc($profil['desa'] ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control"
                  value="<?= esc($profil['kecamatan'] ?? '') ?>">
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Kabupaten / Kota</label>
                <input type="text" name="kabupaten" class="form-control"
                  value="<?= esc($profil['kabupaten'] ?? '') ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-semibold">Provinsi</label>
                <input type="text" name="provinsi" class="form-control"
                  value="<?= esc($profil['provinsi'] ?? '') ?>">
              </div>

              <div class="col-md-2">
                <label class="form-label fw-semibold">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control"
                  value="<?= esc($profil['kode_pos'] ?? '') ?>">
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-4">
                <label class="form-label fw-semibold">Email Sekolah</label>
                <input type="email" name="email" class="form-control"
                  value="<?= esc($profil['email'] ?? '') ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-semibold">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control"
                  value="<?= esc($profil['no_telp'] ?? '') ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-semibold">Website</label>
                <input type="text" name="website" class="form-control"
                  value="<?= esc($profil['website'] ?? '') ?>">
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" class="form-control"
                  value="<?= esc($profil['kepala_sekolah'] ?? '') ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">NIP Kepala Sekolah</label>
                <input type="text" name="nip_kepala" class="form-control"
                  value="<?= esc($profil['nip_kepala'] ?? '') ?>">
              </div>
            </div>

          </div>

          <!-- LOGO -->
          <div class="col-lg-4 text-center">
            <label class="form-label fw-semibold">Logo Sekolah</label>

            <?php if (!empty($profil['logo'])) : ?>
              <img src="<?= base_url('uploads/logo/' . $profil['logo']) ?>"
                class="img-thumbnail mb-3"
                style="max-height:160px;">
            <?php else : ?>
              <div class="border rounded p-4 text-muted mb-3">
                <i class="typcn typcn-image-outline fs-1"></i>
                <div>Belum ada logo</div>
              </div>
            <?php endif; ?>

            <input type="file" name="logo"
              class="form-control"
              accept="image/png,image/jpg,image/jpeg">
            <small class="text-muted d-block mt-1">
              JPG / PNG • Max 2MB
            </small>
          </div>

        </div>

        <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="typcn typcn-save me-1"></i>
            Simpan Profil
          </button>
        </div>

      </form>
    </div>
  </div>

  <!-- ================= GANTI PASSWORD ================= -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-lock-closed-outline me-2"></i>
        Ganti Password Akun
      </h5>
    </div>

    <div class="card-body">
      <form method="post" action="<?= base_url('sekolah/profil/ganti-password') ?>">
        <?= csrf_field() ?>

        <div class="row g-3">
          <?php
          $fields = [
            ['password_lama', 'Password Lama'],
            ['password_baru', 'Password Baru'],
            ['password_konfirmasi', 'Konfirmasi Password Baru'],
          ];
          foreach ($fields as $f):
          ?>
            <div class="col-md-4">
              <label class="form-label fw-semibold"><?= $f[1] ?></label>
              <div class="input-group">
                <input type="password"
                  name="<?= $f[0] ?>"
                  id="<?= $f[0] ?>"
                  class="form-control"
                  required>
                <button class="btn btn-outline-secondary"
                  type="button"
                  onclick="togglePassword('<?= $f[0] ?>', this)">
                  👁️
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="text-end mt-4">
          <button type="submit" class="btn btn-warning px-4">
            <i class="typcn typcn-key-outline me-1"></i>
            Ganti Password
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.innerHTML = input.type === 'text' ? '🙈' : '👁️';
  }
</script>

<?= $this->endSection() ?>
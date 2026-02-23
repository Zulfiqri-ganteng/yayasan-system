<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="mb-1 d-flex align-items-center">
      <i class="typcn typcn-th-large-outline text-primary me-2"></i>
      Pengaturan Fitur Sekolah
    </h4>
    <small class="text-muted">
      Manajemen fitur untuk
      <strong class="text-primary"><?= esc($sekolah['nama_sekolah']) ?></strong>
    </small>
  </div>
</div>

<!-- ================= ALERT ================= -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show">
    <i class="typcn typcn-tick-outline me-1"></i>
    <?= session()->getFlashdata('success') ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show">
    <i class="typcn typcn-warning-outline me-1"></i>
    <?= session()->getFlashdata('error') ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<form id="bulkForm" method="post" action="<?= base_url('admin/sekolah-fitur/bulk') ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="sekolah_id" value="<?= $sekolah['id'] ?>">
  <input type="hidden" name="aksi" id="bulkAksi">

  <div class="card shadow-sm border-0">

    <!-- ================= TOOLBAR ================= -->
    <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div class="fw-semibold text-muted">
        <i class="typcn typcn-settings-outline me-1"></i>
        Kontrol Massal Fitur
      </div>

      <div class="d-flex gap-2">
        <button type="button"
          class="btn btn-success btn-sm"
          onclick="submitBulk('on')">
          <i class="typcn typcn-power-outline me-1"></i>
          Aktifkan
        </button>

        <button type="button"
          class="btn btn-outline-danger btn-sm"
          onclick="submitBulk('off')">
          <i class="typcn typcn-power-outline me-1"></i>
          Nonaktifkan
        </button>
      </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="card-body table-responsive p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="50" class="text-center">
              <input type="checkbox" id="checkAll">
            </th>
            <th>Nama Fitur</th>
            <th width="140" class="text-center">Status</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($fitur as $f): ?>
            <?php
            $isCore = $f['locked'];
            $statusAktif = $isCore ? true : (bool) $f['aktif'];
            ?>
            <tr>

              <!-- CHECKBOX -->
              <td class="text-center">
                <?php if (!$isCore): ?>
                  <input type="checkbox"
                    name="fitur_kode[]"
                    value="<?= esc($f['fitur_kode']) ?>"
                    class="check-item">
                <?php else: ?>
                  <i class="typcn typcn-lock-closed-outline text-muted"
                    title="Fitur inti sistem"></i>
                <?php endif; ?>
              </td>

              <!-- FITUR -->
              <td>
                <div class="fw-semibold d-flex align-items-center">
                  <i class="typcn typcn-puzzle-outline text-primary me-2"></i>
                  <?= esc(ucwords(str_replace('_', ' ', $f['fitur_kode']))) ?>

                  <?php if ($isCore): ?>
                    <span class="badge bg-secondary ms-2">
                      <i class="typcn typcn-lock-closed-outline me-1"></i>
                      CORE
                    </span>
                  <?php endif; ?>
                </div>

                <small class="text-muted">
                  Kode: <?= esc($f['fitur_kode']) ?>
                </small>
              </td>

              <!-- STATUS -->
              <td class="text-center">
                <?php if ($statusAktif): ?>
                  <span class="badge bg-success px-3">
                    <i class="typcn typcn-tick me-1"></i>
                    Aktif
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger px-3">
                    <i class="typcn typcn-times me-1"></i>
                    Nonaktif
                  </span>
                <?php endif; ?>
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</form>

<!-- ================= SCRIPT ================= -->
<script>
  const checkAll = document.getElementById('checkAll');
  const items = document.querySelectorAll('.check-item');

  checkAll?.addEventListener('change', function() {
    items.forEach(cb => cb.checked = this.checked);
  });

  function submitBulk(aksi) {
    const checked = document.querySelectorAll('.check-item:checked');

    if (checked.length === 0) {
      alert('Pilih minimal satu fitur.');
      return;
    }

    const teks = aksi === 'on' ?
      `Anda akan MENGAKTIFKAN ${checked.length} fitur. Lanjutkan?` :
      `Anda akan MENONAKTIFKAN ${checked.length} fitur. Lanjutkan?`;

    if (!confirm(teks)) return;

    document.getElementById('bulkAksi').value = aksi;
    document.getElementById('bulkForm').submit();
  }
</script>

<?= $this->endSection() ?>
<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid master-fitur-container px-lg-4 px-2">

  <!-- ================= HEADER ================= -->
  <div class="page-header">
    <div>
      <h4 class="page-title">
        Master Fitur Sistem
      </h4>
      <p class="page-subtitle">
        Manajemen dan pengaturan seluruh fitur sistem
      </p>
    </div>

    <a href="<?= base_url('admin/fitur/create') ?>"
      class="btn btn-primary btn-add">
      <i class="typcn typcn-plus-outline me-1"></i>
      Tambah Fitur
    </a>
  </div>

  <!-- ================= ALERT ================= -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- ================= TABLE CARD ================= -->
  <div class="card modern-card">

    <div class="card-body p-0">

      <div class="table-responsive">
        <table class="table modern-table align-middle mb-0">

          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Kode</th>
              <th>Nama Fitur</th>
              <th>Kategori</th>
              <th class="text-center" style="width:170px">Aksi</th>
            </tr>
          </thead>

          <tbody>

            <?php if (empty($fitur)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-5">
                  Belum ada data fitur
                </td>
              </tr>
            <?php endif; ?>

            <?php foreach ($fitur as $i => $f): ?>
              <tr>
                <td class="text-muted"><?= $i + 1 ?></td>

                <td>
                  <span class="feature-code">
                    <?= esc($f['kode']) ?>
                  </span>
                </td>

                <td class="fw-semibold">
                  <?= esc($f['nama']) ?>
                </td>

                <td>
                  <span class="badge category-badge">
                    <?= esc($f['kategori']) ?>
                  </span>
                </td>

                <td class="text-center">
                  <div class="action-group">

                    <a href="<?= base_url('admin/fitur/edit/' . $f['id']) ?>"
                      class="btn btn-sm btn-warning">
                      <i class="typcn typcn-edit"></i>
                    </a>

                    <form action="<?= base_url('admin/fitur/delete/' . $f['id']) ?>"
                      method="post"
                      class="d-inline"
                      onsubmit="return confirm('Hapus fitur ini secara permanen?')">
                      <?= csrf_field() ?>
                      <button class="btn btn-sm btn-danger">
                        <i class="typcn typcn-trash"></i>
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>

        </table>
      </div>

    </div>
  </div>

</div>

<style>
  /* ================= WIDTH FIX ================= */

  .master-fitur-container .row {
    --bs-gutter-x: 0.8rem;
  }

  /* ================= HEADER ================= */

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .page-title {
    font-weight: 700;
    margin-bottom: 4px;
  }

  .page-subtitle {
    font-size: 13px;
    color: #6c757d;
    margin: 0;
  }

  .btn-add {
    border-radius: 10px;
    padding: 8px 16px;
  }

  /* ================= CARD ================= */

  .modern-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
  }

  /* ================= TABLE ================= */

  .modern-table thead {
    background: #f8f9fa;
  }

  .modern-table th {
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 1px solid #e9ecef;
  }

  .modern-table td {
    padding: 14px 16px;
    border-top: 1px solid #f1f3f5;
  }

  .modern-table tbody tr:hover {
    background: #f8fafc;
  }

  .feature-code {
    background: #f1f3f5;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-family: monospace;
  }

  .category-badge {
    background: #eef2ff;
    color: #4f46e5;
    font-weight: 500;
    padding: 6px 10px;
    border-radius: 8px;
  }

  .action-group {
    display: flex;
    justify-content: center;
    gap: 6px;
  }

  /* ================= MOBILE FIX ================= */

  @media (max-width: 768px) {

    .master-fitur-container {
      padding-left: 6px !important;
      padding-right: 6px !important;
    }

    .modern-table th,
    .modern-table td {
      padding: 10px;
      font-size: 13px;
    }

    .page-title {
      font-size: 18px;
    }

  }
</style>

<?= $this->endSection() ?>
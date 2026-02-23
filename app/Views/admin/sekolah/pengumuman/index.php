<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- ================= HEADER ================= -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <!-- <h4 class="mb-0 d-flex align-items-center">
      <i class="typcn typcn-megaphone-outline text-primary me-2"></i>
      Pengumuman Sekolah
    </h4> -->

    <a href="<?= base_url('sekolah/pengumuman/create') ?>" class="btn btn-primary">
      <i class="typcn typcn-plus-outline me-1"></i>
      Tambah Pengumuman
    </a>
  </div>

  <!-- ================= ALERT ================= -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= session()->getFlashdata('success') ?>
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif ?>

  <!-- ================= DESKTOP TABLE ================= -->
  <div class="card shadow-sm border-0 d-none d-md-block">
    <div class="card-body table-responsive">
      <table class="table align-middle table-hover">
        <thead class="table-light">
          <tr>
            <th width="60">No</th>
            <th>Judul</th>
            <th width="150">File</th>
            <th width="110">Status</th>
            <th width="140">Tanggal</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php if (empty($pengumuman)): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                <i class="typcn typcn-info-large-outline d-block mb-2"></i>
                Belum ada pengumuman
              </td>
            </tr>
          <?php endif ?>

          <?php foreach ($pengumuman as $i => $p): ?>
            <?php
              $fileUrl = !empty($p['file'])
                ? base_url('uploads/pengumuman/' . $p['file'])
                : null;

              $ext = $fileUrl
                ? strtolower(pathinfo($p['file'], PATHINFO_EXTENSION))
                : null;
            ?>

            <tr>
              <td><?= $i + 1 ?></td>

              <td class="fw-semibold">
                <i class="typcn typcn-document-text text-primary me-1"></i>
                <?= esc($p['judul']) ?>
              </td>

              <!-- FILE -->
              <td>
                <?php if ($fileUrl): ?>

                  <?php if (in_array($ext, ['jpg','jpeg','png','webp'])): ?>
                    <a href="<?= $fileUrl ?>" target="_blank">
                      <img src="<?= $fileUrl ?>"
                           class="rounded shadow-sm"
                           style="width:80px;height:60px;object-fit:cover;">
                    </a>

                  <?php elseif ($ext === 'pdf'): ?>
                    <a href="<?= $fileUrl ?>" target="_blank"
                       class="btn btn-sm btn-outline-danger">
                      <i class="typcn typcn-document me-1"></i> PDF
                    </a>

                  <?php else: ?>
                    <a href="<?= $fileUrl ?>" target="_blank">
                      <?= esc($p['file']) ?>
                    </a>
                  <?php endif ?>

                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif ?>
              </td>

              <!-- STATUS -->
              <td>
                <?php if ($p['status'] === 'publish'): ?>
                  <span class="badge bg-success">
                    <i class="typcn typcn-tick me-1"></i> Publish
                  </span>
                <?php else: ?>
                  <span class="badge bg-secondary">
                    <i class="typcn typcn-times me-1"></i> Draft
                  </span>
                <?php endif ?>
              </td>

              <!-- TANGGAL -->
              <td>
                <?= $p['tanggal_publish']
                  ? date('d M Y', strtotime($p['tanggal_publish']))
                  : '-' ?>
              </td>

              <!-- AKSI -->
              <td>
                <a href="<?= base_url('sekolah/pengumuman/edit/' . $p['id']) ?>"
                   class="btn btn-sm btn-warning me-1">
                  <i class="typcn typcn-edit"></i>
                </a>

                <a href="<?= base_url('sekolah/pengumuman/delete/' . $p['id']) ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Hapus pengumuman ini?')">
                  <i class="typcn typcn-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>

  <!-- ================= MOBILE CARD ================= -->
  <div class="d-md-none">

    <?php if (empty($pengumuman)): ?>
      <div class="card shadow-sm border-0">
        <div class="card-body text-center text-muted py-5">
          <i class="typcn typcn-info-large-outline d-block mb-2"></i>
          Belum ada pengumuman
        </div>
      </div>
    <?php endif ?>

    <?php foreach ($pengumuman as $p): ?>
      <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

          <div class="d-flex justify-content-between mb-2">
            <span class="fw-semibold">
              <i class="typcn typcn-document-text text-primary me-1"></i>
              <?= esc($p['judul']) ?>
            </span>

            <span class="badge <?= $p['status']==='publish'?'bg-success':'bg-secondary' ?>">
              <?= ucfirst($p['status']) ?>
            </span>
          </div>

          <small class="text-muted d-block mb-2">
            <?= $p['tanggal_publish']
              ? date('d M Y', strtotime($p['tanggal_publish']))
              : '-' ?>
          </small>

          <div class="d-grid gap-2">
            <a href="<?= base_url('sekolah/pengumuman/edit/' . $p['id']) ?>"
               class="btn btn-sm btn-warning">
              <i class="typcn typcn-edit me-1"></i> Edit
            </a>

            <a href="<?= base_url('sekolah/pengumuman/delete/' . $p['id']) ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Hapus pengumuman ini?')">
              <i class="typcn typcn-trash me-1"></i> Hapus
            </a>
          </div>

        </div>
      </div>
    <?php endforeach ?>

  </div>

</div>

<?= $this->endSection() ?>

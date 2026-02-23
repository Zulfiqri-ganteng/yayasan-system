<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Data Fasilitas</h5>
    <a href="<?= base_url('sekolah/fasilitas/create') ?>" class="btn btn-primary btn-sm">
      + Tambah
    </a>
  </div>

  <div class="card-body">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif ?>

    <div class="row g-3">
      <?php foreach ($fasilitas as $row): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= base_url('uploads/fasilitas/' . $row['gambar']) ?>"
              class="card-img-top"
              style="height:180px;object-fit:cover">

            <div class="card-body">
              <h6><?= esc($row['nama_fasilitas']) ?></h6>
              <p class="small text-muted">
                <?= esc(word_limiter($row['deskripsi'], 15)) ?>
              </p>
            </div>

            <div class="card-footer text-center">
              <a href="<?= base_url('sekolah/fasilitas/edit/' . $row['id']) ?>"
                class="btn btn-warning btn-sm">Edit</a>

              <a href="<?= base_url('sekolah/fasilitas/delete/' . $row['id']) ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Hapus fasilitas ini?')">
                Hapus
              </a>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

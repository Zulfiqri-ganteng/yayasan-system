<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h5><?= esc($title) ?></h5>
  </div>

  <div class="card-body">
    <form method="post" enctype="multipart/form-data"
      action="<?= isset($data)
        ? base_url('sekolah/fasilitas/update/' . $data['id'])
        : base_url('sekolah/fasilitas/store') ?>">

      <div class="mb-3">
        <label>Nama Fasilitas</label>
        <input type="text" name="nama_fasilitas"
          class="form-control"
          value="<?= esc($data['nama_fasilitas'] ?? '') ?>"
          required>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi"
          class="form-control"
          rows="4"><?= esc($data['deskripsi'] ?? '') ?></textarea>
      </div>

      <div class="mb-3">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">

        <?php if (!empty($data['gambar'])): ?>
          <img src="<?= base_url('uploads/fasilitas/' . $data['gambar']) ?>"
            class="img-thumbnail mt-2"
            style="max-height:120px">
        <?php endif ?>
      </div>

      <div class="text-end">
        <a href="<?= base_url('sekolah/fasilitas') ?>"
          class="btn btn-secondary">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
      </div>

    </form>
  </div>
</div>

<?= $this->endSection() ?>

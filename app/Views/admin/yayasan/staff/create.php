<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- <h4>Tambah Staff Yayasan</h4> -->

<form method="post" action="<?= base_url('admin/yayasan/staff/store') ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label>Nama</label>
    <input type="text" name="nama" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Jabatan</label>
    <input type="text" name="jabatan" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Urutan</label>
    <input type="number" name="urutan" class="form-control" value="0">
  </div>

  <div class="mb-3">
    <label>Foto</label>
    <input type="file" name="foto" class="form-control">
  </div>

  <button class="btn btn-success">Simpan</button>
  <a href="<?= base_url('admin/yayasan/staff') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>

<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">
    Tambah Fitur –
    <span class="text-primary"><?= esc($sekolah['nama_sekolah']) ?></span>
</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('admin/sekolah-fitur/add') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="sekolah_id" value="<?= $sekolah['id'] ?>">

    <div class="card">
        <div class="card-body">

            <?php if (empty($fitur)): ?>
                <div class="alert alert-info mb-0">
                    Semua fitur sudah ditambahkan ke sekolah ini.
                </div>
            <?php else: ?>

                <div class="mb-3">
                    <strong>Pilih fitur yang ingin ditambahkan:</strong>
                </div>

                <div class="row">
                    <?php foreach ($fitur as $f): ?>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="fitur_kode[]"
                                    value="<?= esc($f['kode']) ?>"
                                    id="fitur_<?= esc($f['kode']) ?>">

                                <label class="form-check-label"
                                    for="fitur_<?= esc($f['kode']) ?>">
                                    <?= esc($f['nama']) ?>
                                    <small class="text-muted d-block">
                                        <?= esc($f['kategori']) ?>
                                    </small>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tambahkan Fitur
                    </button>

                    <a href="<?= base_url('admin/sekolah-fitur/' . $sekolah['id']) ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</form>

<?= $this->endSection() ?>
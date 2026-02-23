<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="typcn typcn-plus-outline text-primary me-2"></i>
        Tambah Jurusan
    </h4>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('error') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach ?>
        </ul>
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif ?>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form action="<?= base_url('sekolah/jurusan/store') ?>"
            method="post"
            enctype="multipart/form-data">

            <?= csrf_field() ?>

            <!-- Nama -->
            <div class="mb-3">
                <label class="form-label">Nama Jurusan</label>
                <input type="text"
                    name="nama"
                    value="<?= old('nama') ?>"
                    class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>">

                <?php if (session('errors.nama')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.nama') ?>
                    </div>
                <?php endif ?>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi"
                    rows="4"
                    class="form-control"><?= old('deskripsi') ?></textarea>
            </div>

            <!-- Urutan -->
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number"
                    name="urutan"
                    value="<?= old('urutan', 0) ?>"
                    class="form-control">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" <?= old('status') === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="publish" <?= old('status') === 'publish' ? 'selected' : '' ?>>Publish</option>
                </select>
            </div>

            <!-- Foto -->
            <div class="mb-3">
                <label class="form-label">Foto Cover</label>
                <input type="file"
                    name="foto_cover"
                    class="form-control <?= session('errors.foto_cover') ? 'is-invalid' : '' ?>"
                    accept="image/*"
                    onchange="previewImage(event)">

                <?php if (session('errors.foto_cover')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.foto_cover') ?>
                    </div>
                <?php endif ?>

                <div class="mt-3">
                    <img id="preview"
                        class="rounded shadow-sm d-none"
                        style="width:200px; height:120px; object-fit:cover;">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('sekolah/jurusan') ?>"
                    class="btn btn-secondary">
                    Kembali
                </a>

                <button class="btn btn-primary">
                    <i class="typcn typcn-tick-outline me-1"></i>
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.classList.remove('d-none');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>
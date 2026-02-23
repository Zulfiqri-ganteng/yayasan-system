<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <i class="fa fa-user-plus text-primary me-2 fs-4"></i>
        <h4 class="mb-0 fw-semibold">Tambah Staff Sekolah</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('sekolah/staff/store') ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="row g-3">

                    <!-- NAMA -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Staff</label>
                        <input type="text"
                            name="nama"
                            class="form-control"
                            required>
                    </div>

                    <!-- JABATAN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text"
                            name="jabatan"
                            class="form-control"
                            required>
                    </div>

                    <!-- WALI KELAS -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Wali Kelas
                        </label>
                        <input type="text"
                            name="wali_kelas"
                            class="form-control"
                            placeholder="Contoh: X TKJ 1">
                        <small class="text-muted">
                            Kosongkan jika bukan wali kelas
                        </small>
                    </div>

                    <!-- URUTAN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number"
                            name="urutan"
                            class="form-control"
                            value="0">
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Foto</label>
                        <input type="file"
                            name="foto"
                            class="form-control"
                            accept="image/*">
                        <small class="text-muted">JPG / PNG • Max 2MB</small>
                    </div>

                </div>

                <hr class="my-4">

                <!-- ================= SOCIAL MEDIA ================= -->
                <h6 class="fw-semibold mb-3">
                    <i class="fa fa-share-alt me-2 text-primary"></i>
                    Social Media
                </h6>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Instagram
                        </label>
                        <input type="text"
                            name="instagram"
                            class="form-control"
                            placeholder="https://instagram.com/username">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Facebook
                        </label>
                        <input type="text"
                            name="facebook"
                            class="form-control"
                            placeholder="https://facebook.com/username">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            LinkedIn
                        </label>
                        <input type="text"
                            name="linkedin"
                            class="form-control"
                            placeholder="https://linkedin.com/in/username">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <a href="<?= base_url('sekolah/staff') ?>" class="btn btn-light">
                        Kembali
                    </a>
                    <button class="btn btn-primary px-4">
                        <i class="fa fa-save me-1"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
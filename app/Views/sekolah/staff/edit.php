<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <i class="fa fa-user-edit text-warning me-2 fs-4"></i>
        <h4 class="mb-0 fw-semibold">Edit Staff Sekolah</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('sekolah/staff/update/' . $staff['id']) ?>"
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
                            value="<?= esc($staff['nama']) ?>"
                            required>
                    </div>

                    <!-- JABATAN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text"
                            name="jabatan"
                            class="form-control"
                            value="<?= esc($staff['jabatan']) ?>"
                            required>
                    </div>

                    <!-- WALI KELAS -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Wali Kelas</label>
                        <input type="text"
                            name="wali_kelas"
                            class="form-control"
                            value="<?= esc($staff['wali_kelas'] ?? '') ?>"
                            placeholder="Contoh: X TKJ 1">
                        <small class="text-muted">
                            Kosongkan jika bukan wali kelas
                        </small>
                    </div>

                    <!-- URUTAN -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number"
                            name="urutan"
                            class="form-control"
                            value="<?= esc($staff['urutan']) ?>">
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?= $staff['status'] === 'aktif' ? 'selected' : '' ?>>
                                Aktif
                            </option>
                            <option value="nonaktif" <?= $staff['status'] === 'nonaktif' ? 'selected' : '' ?>>
                                Nonaktif
                            </option>
                        </select>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ganti Foto</label>
                        <input type="file"
                            name="foto"
                            class="form-control"
                            accept="image/*">

                        <?php if (!empty($staff['foto'])): ?>
                            <div class="mt-3 text-center">
                                <img src="<?= base_url('uploads/staff/' . $staff['foto']) ?>"
                                    class="rounded-circle shadow-sm"
                                    style="width:120px;height:120px;object-fit:cover;">
                            </div>
                        <?php endif ?>
                    </div>

                </div>

                <hr class="my-4">

                <!-- SOCIAL MEDIA -->
                <h6 class="fw-semibold mb-3">
                    <i class="fa fa-share-alt me-2 text-primary"></i>
                    Social Media
                </h6>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Instagram</label>
                        <input type="text"
                            name="instagram"
                            class="form-control"
                            value="<?= esc($staff['instagram'] ?? '') ?>"
                            placeholder="https://instagram.com/username">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Facebook</label>
                        <input type="text"
                            name="facebook"
                            class="form-control"
                            value="<?= esc($staff['facebook'] ?? '') ?>"
                            placeholder="https://facebook.com/username">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">LinkedIn</label>
                        <input type="text"
                            name="linkedin"
                            class="form-control"
                            value="<?= esc($staff['linkedin'] ?? '') ?>"
                            placeholder="https://linkedin.com/in/username">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <a href="<?= base_url('sekolah/staff') ?>" class="btn btn-light">
                        Kembali
                    </a>
                    <button class="btn btn-warning px-4">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
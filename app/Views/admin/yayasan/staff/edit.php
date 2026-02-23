<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">
                <i class="typcn typcn-edit text-warning me-1"></i>
                Edit Staff Yayasan
            </div>

            <div class="card-body">
                <form action="<?= base_url('admin/yayasan/staff/update/' . $staff['id']) ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="nama"
                               class="form-control"
                               value="<?= esc($staff['nama']) ?>"
                               required>
                    </div>

                    <!-- JABATAN -->
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text"
                               name="jabatan"
                               class="form-control"
                               value="<?= esc($staff['jabatan']) ?>"
                               required>
                    </div>

                    <!-- URUTAN -->
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number"
                               name="urutan"
                               class="form-control"
                               value="<?= esc($staff['urutan']) ?>">
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?= $staff['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= $staff['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>

                    <!-- FOTO -->
                    <div class="mb-4">
                        <label class="form-label">Foto Staff</label>
                        <input type="file" name="foto" class="form-control">

                        <?php if (!empty($staff['foto'])): ?>
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                                <img src="<?= base_url('uploads/staff/' . $staff['foto']) ?>"
                                     class="rounded shadow-sm"
                                     style="width:120px;height:120px;object-fit:cover">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/yayasan/staff') ?>"
                           class="btn btn-light">
                            <i class="typcn typcn-arrow-back-outline me-1"></i>
                            Kembali
                        </a>

                        <button class="btn btn-warning">
                            <i class="typcn typcn-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<form action="<?= base_url('admin/yayasan/profil/save') ?>"
    method="post"
    enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">

        <!-- KOLOM KIRI -->
        <div class="col-md-8 col-12">

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Yayasan</label>
                <input type="text" name="nama_yayasan" class="form-control"
                    value="<?= $profil['nama_yayasan'] ?? '' ?>" required>
            </div>

           

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= $profil['alamat'] ?? '' ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 col-12 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= $profil['email'] ?? '' ?>">
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="telepon" class="form-control"
                        value="<?= $profil['telepon'] ?? '' ?>">
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <label class="form-label fw-semibold">Website</label>
                    <input type="text" name="website" class="form-control"
                        value="<?= $profil['website'] ?? '' ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Singkat</label>
                <textarea name="deskripsi_singkat" class="form-control" rows="3"><?= $profil['deskripsi_singkat'] ?? '' ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Google Maps Embed</label>
                <textarea name="google_maps" class="form-control" rows="3"><?= $profil['google_maps'] ?? '' ?></textarea>
            </div>

        </div>

        <!-- KOLOM KANAN (LOGO) -->
        <div class="col-md-4 col-12">
            <label class="form-label fw-semibold">Logo Yayasan</label>

            <input type="file" name="logo" class="form-control mb-2">

            <?php if (!empty($profil['logo'])) : ?>
                <div class="border rounded p-3 text-center">
                    <img src="<?= base_url('uploads/yayasan/' . $profil['logo']) ?>"
                        class="img-fluid"
                        style="max-height:120px;">
                </div>
            <?php else : ?>
                <div class="border rounded p-4 text-center text-muted">
                    <i class="typcn typcn-image-outline fs-2"></i>
                    <div>Belum ada logo</div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="text-end mt-4">
        <button class="btn btn-primary px-4">
            <i class="typcn typcn-save me-1"></i>
            Simpan Profil
        </button>
    </div>

</form>
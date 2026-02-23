<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<div class="d-flex align-items-center mb-4">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-edit text-primary me-2"></i>
        Edit Akademik
    </h4>
</div>

<form action="<?= base_url('admin/yayasan/akademik/update/' . $data['id']) ?>"
    method="post"
    enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row g-3">

                <!-- JENJANG -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-mortar-board me-1"></i>
                        Jenjang
                    </label>
                    <select name="jenjang" class="form-select" required>
                        <?php foreach (['kb', 'sd', 'smp', 'sma', 'smk'] as $j): ?>
                            <option value="<?= $j ?>" <?= $data['jenjang'] === $j ? 'selected' : '' ?>>
                                <?= strtoupper($j) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- NAMA SEKOLAH -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-home-outline me-1"></i>
                        Nama Sekolah
                    </label>
                    <input type="text"
                        name="nama_sekolah"
                        class="form-control"
                        value="<?= esc($data['nama_sekolah']) ?>"
                        required>
                </div>

                <!-- DESKRIPSI -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-document-text me-1"></i>
                        Deskripsi
                    </label>
                    <textarea name="deskripsi"
                        rows="4"
                        class="form-control"><?= esc($data['deskripsi']) ?></textarea>
                </div>

                <!-- KEPALA SEKOLAH -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-user-outline me-1"></i>
                        Kepala Sekolah
                    </label>
                    <input type="text"
                        name="nama_kepsek"
                        class="form-control"
                        value="<?= esc($data['nama_kepsek']) ?>">
                </div>

                <!-- FOTO KEPSEK -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-camera-outline me-1"></i>
                        Foto Kepala Sekolah
                    </label>
                    <input type="file" name="foto_kepsek" class="form-control">
                    <?php if (!empty($data['foto_kepsek'])): ?>
                        <small class="text-muted d-block mt-1">
                            File saat ini: <?= esc($data['foto_kepsek']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <!-- FOTO SEKOLAH -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-image-outline me-1"></i>
                        Foto Sekolah
                    </label>
                    <input type="file" name="foto_sekolah" class="form-control">
                    <?php if (!empty($data['foto_sekolah'])): ?>
                        <small class="text-muted d-block mt-1">
                            File saat ini: <?= esc($data['foto_sekolah']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <!-- URUTAN -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-sort-numerically me-1"></i>
                        Urutan
                    </label>
                    <input type="number"
                        name="urutan"
                        class="form-control"
                        value="<?= esc($data['urutan']) ?>">
                </div>

                <!-- STATUS -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="typcn typcn-power-outline me-1"></i>
                        Status
                    </label>
                    <select name="status" class="form-select">
                        <option value="aktif" <?= $data['status'] === 'aktif' ? 'selected' : '' ?>>
                            Aktif
                        </option>
                        <option value="nonaktif" <?= $data['status'] === 'nonaktif' ? 'selected' : '' ?>>
                            Nonaktif
                        </option>
                    </select>
                </div>

            </div>
        </div>

        <!-- ================= FOOTER ================= -->
        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="<?= base_url('admin/yayasan/akademik') ?>" class="btn btn-secondary">
                <i class="typcn typcn-arrow-left me-1"></i>
                Kembali
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="typcn typcn-tick-outline me-1"></i>
                Update Akademik
            </button>
        </div>
    </div>

</form>

<?= $this->endSection() ?>
<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="typcn typcn-edit text-warning me-2"></i>
            Edit PPDB
        </h4>
        <a href="<?= base_url('sekolah/ppdb') ?>" class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

    <!-- ================= FORM ================= -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('sekolah/ppdb/update/' . $ppdb['id']) ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- JUDUL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul PPDB</label>
                    <input type="text"
                        name="judul"
                        class="form-control"
                        value="<?= esc($ppdb['judul']) ?>"
                        required>
                </div>

                <!-- TAHUN AJARAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tahun Ajaran</label>
                    <input type="text"
                        name="tahun_ajaran"
                        class="form-control"
                        value="<?= esc($ppdb['tahun_ajaran']) ?>"
                        required>
                </div>

                <!-- TANGGAL -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="<?= esc($ppdb['tanggal_mulai']) ?>"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date"
                            name="tanggal_selesai"
                            class="form-control"
                            value="<?= esc($ppdb['tanggal_selesai']) ?>"
                            required>
                    </div>
                </div>

                <!-- DESKRIPSI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi"
                        rows="5"
                        class="form-control"><?= esc($ppdb['deskripsi']) ?></textarea>
                </div>

                <!-- BANNER SAAT INI -->
                <?php if (!empty($ppdb['banner'])) : ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Banner Saat Ini</label><br>
                        <img src="<?= base_url('uploads/ppdb/' . session()->get('sekolah_id') . '/' . $ppdb['banner']) ?>"
                            class="img-thumbnail"
                            style="max-width:250px;">
                    </div>
                <?php endif ?>

                <!-- GANTI BANNER -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ganti Banner (Opsional)</label>
                    <input type="file"
                        name="banner"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                        onchange="previewBanner(event)">

                    <small class="text-muted">
                        Maksimal 2MB • Format JPG / PNG / WebP
                    </small>

                    <div class="mt-3">
                        <img id="bannerPreview"
                            class="img-thumbnail d-none"
                            style="max-width:250px;">
                    </div>
                </div>

                <!-- STATUS -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" <?= $ppdb['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="buka" <?= $ppdb['status'] == 'buka' ? 'selected' : '' ?>>Buka</option>
                        <option value="tutup" <?= $ppdb['status'] == 'tutup' ? 'selected' : '' ?>>Tutup</option>
                    </select>

                    <small class="text-muted">
                        Jika memilih <strong>Buka</strong>, PPDB lain otomatis ditutup.
                    </small>
                </div>

                <!-- ACTION -->
                <div class="text-end">
                    <button class="btn btn-primary px-4">
                        <i class="typcn typcn-tick-outline me-1"></i>
                        Update PPDB
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- ================= JS PREVIEW ================= -->
<script>
    function previewBanner(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('bannerPreview');
            output.src = reader.result;
            output.classList.remove('d-none');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>
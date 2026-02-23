<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= HEADER ================= -->
<!-- <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="mb-0 d-flex align-items-center">
        <i class="typcn typcn-news text-primary me-2"></i>
        Tambah Berita Sekolah
    </h4>

    <a href="<?= base_url('sekolah/berita') ?>"
        class="btn btn-secondary">
        <i class="typcn typcn-arrow-back-outline me-1"></i>
        Kembali
    </a>
</div> -->

<!-- ================= FORM ================= -->
<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="post"
              action="<?= base_url('sekolah/berita/store') ?>"
              enctype="multipart/form-data">

            <?= csrf_field() ?>

            <!-- JUDUL -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="typcn typcn-document-text me-1 text-primary"></i>
                    Judul Berita
                </label>
                <input type="text"
                       name="judul"
                       class="form-control"
                       placeholder="Masukkan judul berita"
                       required>
            </div>

            <!-- RINGKASAN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="typcn typcn-notes-outline me-1 text-primary"></i>
                    Ringkasan
                </label>
                <textarea name="ringkasan"
                          rows="3"
                          class="form-control"
                          placeholder="Ringkasan singkat berita"></textarea>
            </div>

            <!-- KONTEN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="typcn typcn-edit me-1 text-primary"></i>
                    Konten Berita
                </label>
                <textarea name="konten"
                          rows="8"
                          class="form-control"
                          placeholder="Isi lengkap berita"
                          required></textarea>
            </div>

            <!-- FEATURED IMAGE -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="typcn typcn-image-outline me-1 text-primary"></i>
                    Featured Image
                </label>
                <input type="file"
                       name="featured_image"
                       class="form-control"
                       accept="image/*">
                <small class="text-muted">
                    JPG / PNG / WEBP, max 2MB
                </small>
            </div>

            <!-- STATUS -->
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    <i class="typcn typcn-flag-outline me-1 text-primary"></i>
                    Status
                </label>
                <select name="status" class="form-select">
                    <option value="draft">Draft</option>
                    <option value="publish">Publish</option>
                </select>
            </div>

            <!-- ACTION -->
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary px-4">
                    <i class="typcn typcn-save me-1"></i>
                    Simpan Berita
                </button>

                <a href="<?= base_url('sekolah/berita') ?>"
                   class="btn btn-light">
                    Batal
                </a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>

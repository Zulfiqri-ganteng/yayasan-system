<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Edit Pengumuman</h4>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('sekolah/pengumuman/update/' . $pengumuman['id']) ?>"
                method="post"
                enctype="multipart/form-data">

                <?= csrf_field() ?>

                <!-- JUDUL -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Pengumuman</label>
                    <input type="text"
                        name="judul"
                        class="form-control"
                        value="<?= esc($pengumuman['judul']) ?>"
                        required>
                </div>

                <!-- ISI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Isi Pengumuman</label>
                    <textarea name="isi"
                        rows="6"
                        class="form-control"
                        required><?= esc($pengumuman['isi']) ?></textarea>
                </div>

                <!-- FILE LAMA -->
                <?php if (!empty($pengumuman['file'])): ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File Saat Ini</label>

                        <?php
                        $ext = pathinfo($pengumuman['file'], PATHINFO_EXTENSION);
                        $fileUrl = base_url('uploads/pengumuman/' . $pengumuman['file']);
                        ?>

                        <?php if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])): ?>
                            <div class="mb-2">
                                <img src="<?= $fileUrl ?>"
                                    class="img-thumbnail"
                                    style="max-height: 200px;">
                            </div>
                        <?php endif; ?>

                        <a href="<?= $fileUrl ?>" target="_blank">
                            <?= esc($pengumuman['file']) ?>
                        </a>

                        <small class="text-muted d-block">
                            File lama akan dihapus otomatis jika diganti
                        </small>
                    </div>
                <?php endif; ?>

                <!-- GANTI FILE -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ganti Gambar / PDF (Opsional)</label>
                    <input type="file"
                        name="file"
                        class="form-control">
                    <small class="text-muted">
                        JPG / PNG / WEBP / PDF • Max 4MB
                    </small>
                </div>

                <!-- STATUS -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" <?= $pengumuman['status'] === 'draft' ? 'selected' : '' ?>>
                            Draft
                        </option>
                        <option value="publish" <?= $pengumuman['status'] === 'publish' ? 'selected' : '' ?>>
                            Publish
                        </option>
                    </select>
                </div>

                <!-- ACTION -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                    <a href="<?= base_url('sekolah/pengumuman') ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
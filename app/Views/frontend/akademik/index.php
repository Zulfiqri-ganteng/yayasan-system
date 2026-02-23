<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= PAGE HEADER ================= -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white">Akademik Kami</h1>
                <p class="text-white fs-5 mt-3">
                    Setiap jenjang memiliki program unggulan dan dikelola secara profesional
                </p>
            </div>
        </div>
    </div>
</div>


<!-- ================= AKADEMIK LIST ================= -->
<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-4 justify-content-center">

            <?php foreach ($akademik as $row): ?>
                <?php if (($row['status'] ?? 'aktif') !== 'aktif') continue; ?>

                <div class="col-lg-4 col-md-6">
                    <div class="course-item bg-light h-100 text-center">

                        <div class="p-4 pb-0">

                            <span class="badge bg-primary text-uppercase mb-2">
                                <?= esc($row['jenjang']) ?>
                            </span>

                            <h5 class="mb-2">
                                <?= esc($row['nama_sekolah']) ?>
                            </h5>

                            <?php if (!empty($row['deskripsi'])): ?>
                                <p class="small text-muted">
                                    <?= esc(word_limiter(strip_tags($row['deskripsi']), 18)) ?>
                                </p>
                            <?php else: ?>
                                <p class="small text-muted">
                                    Program pendidikan unggulan jenjang <?= esc($row['jenjang']) ?>.
                                </p>
                            <?php endif; ?>

                        </div>

                        <div class="d-flex border-top">
                            <a href="<?= base_url('akademik/' . strtolower($row['jenjang'])) ?>"
                                class="flex-fill text-center py-3 text-primary fw-bold">
                                Lihat Detail →
                            </a>
                        </div>

                    </div>
                </div>

            <?php endforeach ?>

        </div>

    </div>
</div>

<?= $this->endSection() ?>
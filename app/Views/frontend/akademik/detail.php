<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= PAGE HEADER ================= -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-4 text-white">
                    <?= esc($data['nama_sekolah']) ?>
                </h1>
                <p class="text-white fs-5 mt-3">
                    Jenjang Pendidikan <?= esc(strtoupper($data['jenjang'] ?? '')) ?>
                </p>
            </div>
        </div>
    </div>
</div>


<!-- ================= PROFIL SEKOLAH ================= -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">

            <!-- DESKRIPSI -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="fw-bold mb-3">
                    Tentang Sekolah
                </h3>

                <p class="text-muted">
                    <?= nl2br(esc(
                        (string) (
                            is_array($data['deskripsi'])
                            ? implode(' ', $data['deskripsi'])
                            : ($data['deskripsi'] ?? '')
                        )
                    )) ?>

                </p>
            </div>

            <!-- FOTO SEKOLAH -->
            <div class="col-lg-6 text-center wow fadeInUp" data-wow-delay="0.3s">
                <?php if (!empty($data['foto_sekolah'])): ?>
                    <img
                        src="<?= base_url('uploads/akademik/' . $data['foto_sekolah']) ?>"
                        class="img-fluid rounded shadow"
                        alt="<?= esc($data['nama_sekolah']) ?>">
                <?php else: ?>
                    <img
                        src="<?= base_url('theme/img/about.jpg') ?>"
                        class="img-fluid rounded shadow"
                        alt="Sekolah">
                <?php endif ?>
            </div>

        </div>
    </div>
</div>


<!-- ================= KEPALA SEKOLAH ================= -->
<?php if (!empty($data['nama_kepsek'])): ?>
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- FOTO -->
                <div class="col-lg-4 text-center">
                    <?php if (!empty($data['foto_kepsek'])): ?>
                        <img
                            src="<?= base_url('uploads/akademik/' . $data['foto_kepsek']) ?>"
                            class="rounded-circle shadow"
                            style="width:200px;height:200px;object-fit:cover"
                            alt="<?= esc($data['nama_kepsek']) ?>">
                    <?php else: ?>
                        <img
                            src="<?= base_url('theme/img/team-1.jpg') ?>"
                            class="rounded-circle shadow"
                            style="width:200px;height:200px;object-fit:cover"
                            alt="Kepala Sekolah">
                    <?php endif ?>
                </div>

                <!-- INFO -->
                <div class="col-lg-8">
                    <h4 class="fw-bold mb-1">
                        <?= esc($data['nama_kepsek']) ?>
                    </h4>
                    <p class="text-muted mb-3">
                        Kepala Sekolah
                    </p>

                    <p class="fst-italic">
                        Berkomitmen membangun lingkungan belajar yang unggul,
                        berkarakter, dan berdaya saing.
                    </p>
                </div>

            </div>
        </div>
    </div>
<?php endif ?>


<!-- ================= BACK ================= -->
<div class="container text-center py-5">
    <a href="<?= base_url('akademik') ?>" class="btn btn-outline-primary">
        ← Kembali ke Akademik
    </a>
</div>

<?= $this->endSection() ?>
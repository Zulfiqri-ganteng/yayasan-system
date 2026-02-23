<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageTitle' => esc($ekskul['nama']),
    'minimalHeader' => true
]) ?>

<style>
    /* ================= GLOBAL ================= */
    .container-narrow {
        max-width: 1140px;
        margin: auto;
    }

    /* ================= HERO ================= */
    .ekskul-hero {
        padding: 80px 0;
        background: #ffffff;
    }

    .ekskul-title {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 20px;
        color: #0f1f45;
    }

    .ekskul-meta {
        margin-bottom: 25px;
        font-size: 15px;
        color: #6c757d;
    }

    .ekskul-meta strong {
        color: #0f1f45;
    }

    .ekskul-desc {
        font-size: 16px;
        color: #6c757d;
        line-height: 1.8;
    }

    .ekskul-image-wrap img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    }

    /* ================= INFO SECTION ================= */
    .section-modern {
        padding: 80px 0;
    }

    .info-card {
        padding: 30px;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        height: 100%;
    }

    .info-card h5 {
        font-weight: 700;
        color: #0f1f45;
    }

    /* ================= CTA ================= */
    .cta-modern {
        background: linear-gradient(135deg, #0f1f45, #142d5e);
        color: #fff;
        padding: 70px 40px;
        border-radius: 24px;
        text-align: center;
    }

    /* ================= MOBILE ================= */
    @media (max-width:768px) {

        .ekskul-hero {
            padding: 50px 0;
            text-align: center;
        }

        .ekskul-title {
            font-size: 24px;
        }

        .section-modern {
            padding: 50px 0;
        }
    }
</style>

<!-- ================= HERO ================= -->
<section class="ekskul-hero">
    <div class="container container-narrow">
        <div class="row align-items-center g-5">

            <div class="col-lg-6 order-lg-1 order-2">

                <h2 class="ekskul-title">
                    <?= esc($ekskul['nama']) ?>
                </h2>

                <div class="ekskul-meta">
                    <div><strong>Pembina:</strong> <?= esc($ekskul['pembina']) ?></div>
                    <div><strong>Jadwal:</strong> <?= esc($ekskul['jadwal']) ?></div>
                    <div><strong>Tempat:</strong> <?= esc($ekskul['tempat']) ?></div>
                </div>

                <p class="ekskul-desc">
                    <?= nl2br(esc((string)$ekskul['deskripsi'])) ?>
                </p>

                <a href="<?= $ctxUrl('kesiswaan') ?>" class="btn btn-dark btn-lg px-4 mt-3">
                    ← Kembali ke Kesiswaan
                </a>

            </div>

            <div class="col-lg-6 order-lg-2 order-1">
                <div class="ekskul-image-wrap">
                    <img src="<?= base_url('uploads/ekstrakurikuler/' . $ekskul['sekolah_id'] . '/' . $ekskul['gambar']) ?>" alt="">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= INFORMASI TAMBAHAN ================= -->
<section class="section-modern bg-light">
    <div class="container container-narrow">
        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="info-card">
                    <h5>Pengembangan Skill</h5>
                    <p class="text-muted">
                        Mengembangkan keterampilan teknis dan soft skill siswa secara berkelanjutan.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <h5>Kerja Tim</h5>
                    <p class="text-muted">
                        Melatih kepemimpinan, komunikasi, dan kolaborasi antar siswa.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <h5>Prestasi</h5>
                    <p class="text-muted">
                        Membuka peluang mengikuti lomba dan kompetisi tingkat sekolah hingga nasional.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="section-modern">
    <div class="container container-narrow">
        <div class="cta-modern">
            <h3 class="mb-3">
                Tertarik bergabung di <?= esc($ekskul['nama']) ?>?
            </h3>
            <p class="mb-4">
                Hubungi pembina atau daftar melalui sekolah untuk ikut serta dalam kegiatan ini.
            </p>
            <a href="<?= $ctxUrl('ppdb') ?>" class="btn btn-warning btn-lg">
                Daftar Sekarang
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageTitle' => $jurusan['nama'],
    'minimalHeader' => true
]) ?>

<style>
    /* ================= GLOBAL ================= */
    .container-narrow {
        max-width: 1140px;
        margin: auto;
    }

    /* ================= HERO ================= */

    .jurusan-hero {
        padding: 80px 0;
        background: #ffffff;
    }

    .jurusan-title {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 20px;
        color: #0f1f45;
    }

    .jurusan-desc {
        font-size: 16px;
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .jurusan-image-wrap img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    }

    /* ================= STATS ================= */

    .jurusan-stats {
        padding: 70px 0;
        background: #f8f9fa;
    }

    .stat-card {
        padding: 30px;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }

    .stat-card h3 {
        font-size: 28px;
        font-weight: 700;
        color: #0f1f45;
    }

    .stat-card p {
        font-size: 14px;
        color: #6c757d;
    }

    /* ================= SECTION ================= */

    .section-modern {
        padding: 80px 0;
    }

    .section-modern h3 {
        font-weight: 700;
        margin-bottom: 25px;
        color: #0f1f45;
    }

    /* ================= ACCORDION ================= */

    .accordion-item {
        border-radius: 14px !important;
        overflow: hidden;
        border: none;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
    }

    .accordion-button {
        font-weight: 600;
    }

    .accordion-button:not(.collapsed) {
        background: #0f1f45;
        color: #ffffff;
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

        .jurusan-hero {
            padding: 50px 0;
            text-align: center;
        }

        .jurusan-title {
            font-size: 24px;
        }

        .section-modern {
            padding: 50px 0;
        }

        .jurusan-stats {
            padding: 50px 0;
        }
    }
</style>

<!-- ================= HERO ================= -->
<section class="jurusan-hero">
    <div class="container container-narrow">
        <div class="row align-items-center g-5">

            <div class="col-lg-6 order-lg-1 order-2">
            

                <p class="jurusan-desc">
                    <?= nl2br(esc((string)$jurusan['deskripsi'])) ?>
                </p>

                <a href="<?= $ctxUrl('ppdb') ?>" class="btn btn-dark btn-lg px-4">
                    <?= lang('App.apply_now') ?>
                </a>
            </div>

            <div class="col-lg-6 order-lg-2 order-1">
                <div class="jurusan-image-wrap">
                    <img src="<?= base_url('uploads/sekolah/jurusan/' . $jurusan['foto_cover']) ?>" alt="">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= STATS ================= -->
<section class="jurusan-stats">
    <div class="container container-narrow">
        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="stat-card">
                    <h3 class="counter" data-target="<?= $jumlahSiswa ?? 0 ?>">0</h3>
                    <p><?= lang('App.active_students') ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <h3>3</h3>
                    <p><?= lang('App.study_duration') ?></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <h3>98%</h3>
                    <p><?= lang('App.graduation_rate') ?></p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= KEUNGGULAN ================= -->
<section class="section-modern bg-light">
    <div class="container container-narrow">
        <div class="row g-5">

            <div class="col-lg-6">
                <h3><?= lang('App.why_choose_major') ?></h3>
                <ul class="text-muted">
                    <li><?= lang('App.major_feature_1') ?></li>
                    <li><?= lang('App.major_feature_2') ?></li>
                    <li><?= lang('App.major_feature_3') ?></li>
                    <li><?= lang('App.major_feature_4') ?></li>
                </ul>
            </div>

            <div class="col-lg-6">
                <h3><?= lang('App.career_prospects') ?></h3>
                <p class="text-muted">
                    <?= lang('App.career_desc', ['major' => esc($jurusan['nama'])]) ?>
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ================= KURIKULUM ================= -->
<section class="section-modern">
    <div class="container container-narrow">
        <h3 class="text-center mb-5">
            <?= lang('App.curriculum_structure') ?>
        </h3>

        <div class="accordion" id="curriculumAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#year1">
                        <?= lang('App.year_1') ?>
                    </button>
                </h2>
                <div id="year1" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <?= lang('App.curriculum_year_1') ?>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#year2">
                        <?= lang('App.year_2') ?>
                    </button>
                </h2>
                <div id="year2" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <?= lang('App.curriculum_year_2') ?>
                    </div>
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
                Siap bergabung di <?= esc($jurusan['nama']) ?>?
            </h3>
            <a href="<?= $ctxUrl('ppdb') ?>" class="btn btn-warning btn-lg">
                <?= lang('App.apply_now') ?>
            </a>
        </div>
    </div>
</section>

<!-- COUNTER SCRIPT -->
<script>
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const speed = 20;

        const update = () => {
            const inc = target / 60;
            if (count < target) {
                count += inc;
                counter.innerText = Math.ceil(count);
                setTimeout(update, speed);
            } else {
                counter.innerText = target;
            }
        };
        update();
    });
</script>

<?= $this->endSection() ?>
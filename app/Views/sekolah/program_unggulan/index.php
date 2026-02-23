<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.program_unggulan'),
    'pageTitle' => lang('App.program_major_unit', ['name' => $institutionName])
]) ?>

<style>
    .program-section {
        /* padding: 50px 0 90px; */
        background: #f8f9fc;
        padding: 60px 0 80px;
    }

    /* ===== GRID WRAPPER ===== */
    .program-grid {
        margin-top: 10px;
    }

    /* ===== CARD ===== */
    .program-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 50px 35px;
        text-align: center;
        transition: all .35s ease;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        height: 100%;
        position: relative;
    }

    .program-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 70px rgba(15, 31, 69, 0.15);
    }

    /* ===== ICON ===== */
    .program-icon {
        width: 85px;
        height: 85px;
        margin: 0 auto 25px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0f1f45, #132c5c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        color: #ffffff;
        box-shadow: 0 15px 35px rgba(15, 31, 69, 0.35);
    }

    /* ===== TITLE ===== */
    .program-card h4 {
        font-weight: 700;
        color: #0f1f45;
        margin-bottom: 15px;
    }

    /* ===== DESC ===== */
    .program-card p {
        color: #6c757d;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 30px;
    }

    /* ===== BUTTON ===== */
    .program-btn {
        display: inline-block;
        padding: 10px 26px;
        border-radius: 8px;
        font-weight: 600;
        background: linear-gradient(135deg, #0f1f45, #132c5c);
        color: #fff;
        text-decoration: none;
        transition: .3s ease;
    }

    .program-btn:hover {
        background: linear-gradient(135deg, #132c5c, #1a3c75);
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .program-section {
            padding-top: 10px;
            padding-bottom: 50px;
        }
    }
</style>

<div class="program-section">
    <div class="container">

        <div class="row program-grid g-4">

            <!-- ================= JURUSAN ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h4><?= lang('App.jurusan') ?></h4>
                    <p><?= lang('App.program_jurusan_desc') ?></p>
                    <a href="<?= $ctxUrl('program-unggulan/jurusan') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

            <!-- ================= PKL ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4><?= lang('App.pkl') ?></h4>
                    <p><?= lang('App.program_pkl_desc') ?></p>
                    <a href="<?= $ctxUrl('program-unggulan/pkl') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

            <!-- ================= BKK ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4><?= lang('App.bkk') ?></h4>
                    <p><?= lang('App.program_bkk_desc') ?></p>
                    <a href="<?= $ctxUrl('program-unggulan/bkk') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<?= $this->endSection() ?>
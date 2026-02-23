<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.kesiswaan'),
    'pageTitle' => lang('App.kesiswaan')
]) ?>

<style>
    .program-section {
        background: #f8f9fc;
        padding: 60px 0 80px;
    }

    .program-grid {
        margin-top: 10px;
    }

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

    .program-card h4 {
        font-weight: 700;
        color: #0f1f45;
        margin-bottom: 15px;
    }

    .program-card p {
        color: #6c757d;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 30px;
    }

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

            <!-- ================= EKSTRAKURIKULER ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4><?= lang('App.ekstrakurikuler') ?></h4>
                    <p><?= lang('App.extracurricular_desc') ?></p>
                    <a href="<?= $ctxUrl('kesiswaan/ekstrakurikuler') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

            <!-- ================= OSIS ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h4><?= lang('App.osis') ?></h4>
                    <p><?= lang('App.osis_desc') ?></p>
                    <a href="<?= $ctxUrl('kesiswaan/osis') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

            <!-- ================= PRESTASI (optional future) ================= -->
            <div class="col-lg-4">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4><?= lang('App.student_achievement') ?></h4>
                    <p><?= lang('App.student_achievement_desc') ?></p>
                    <a href="<?= $ctxUrl('kesiswaan/prestasi') ?>" class="program-btn">
                        <?= lang('App.learn_more') ?>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<?= $this->endSection() ?>
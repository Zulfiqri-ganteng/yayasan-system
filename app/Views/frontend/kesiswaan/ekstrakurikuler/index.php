<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.ekstrakurikuler'),
    'pageTitle' => lang('App.ekstrakurikuler')
]) ?>

<div class="container-xxl py-5">
    <div class="container">

        <?php if (!empty($ekskul)): ?>
            <div class="row g-4">

                <?php foreach ($ekskul as $row): ?>
                    <div class="col-lg-4 col-md-6">

                        <div class="program-card text-center">

                            <img src="<?= base_url('uploads/ekstrakurikuler/' . $row['sekolah_id'] . '/' . $row['gambar']) ?>"
                                class="img-fluid rounded mb-3"
                                style="height:220px; object-fit:cover;">

                            <h5><?= esc($row['nama']) ?></h5>

                            <p>
                                <?= esc($row['jadwal']) ?><br>
                                <?= esc($row['tempat']) ?>
                            </p>

                            <a href="<?= $ctxUrl('kesiswaan/ekstrakurikuler/' . $row['slug']) ?>"
                                class="program-btn">
                                <?= lang('App.learn_more') ?>
                            </a>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="alert alert-info text-center">
                <?= lang('App.extracurricular_not_available') ?>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
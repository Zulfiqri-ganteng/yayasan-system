<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .jurusan-card {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        transition: all .4s ease;
    }

    .jurusan-card img {
        transition: transform .6s ease;
    }

    .jurusan-card:hover img {
        transform: scale(1.08);
    }

    .jurusan-info {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #fff;
        padding: 15px 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .jurusan-info h5 {
        margin: 0;
        font-weight: 600;
    }

    .jurusan-info small {
        color: #0dcaf0;
    }
</style>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.program_unggulan'),
    'pageTitle' => lang('App.program_major_unit', ['name' => $institutionName])
]) ?>

<div class="container-xxl py-5">
    <div class="container">

        <?php if (!empty($jurusan)): ?>

            <div class="row g-4">

                <!-- ===================== LEFT BIG ===================== -->
                <div class="col-lg-7 col-md-12">

                    <?php $main = $jurusan[0]; ?>

                    <a href="<?= $ctxUrl('program-unggulan/jurusan/' . $main['slug']) ?>"
                        class="jurusan-card d-block">

                        <img src="<?= base_url('uploads/sekolah/jurusan/' . $main['foto_cover']) ?>"
                            class="img-fluid w-100"
                            style="height:420px; object-fit:cover;">

                        <div class="jurusan-info">
                            <h5><?= esc($main['nama']) ?></h5>
                            <small>
                                <?= count($jurusan) . ' ' . lang('App.program_keahlian') ?>
                            </small>
                        </div>

                    </a>

                </div>

                <!-- ===================== RIGHT SMALL ===================== -->
                <div class="col-lg-5 col-md-12">
                    <div class="row g-4">

                        <?php foreach (array_slice($jurusan, 1, 2) as $row): ?>

                            <div class="col-12">

                                <a href="<?= $ctxUrl('program-unggulan/jurusan/' . $row['slug']) ?>"
                                    class="jurusan-card d-block">

                                    <img src="<?= base_url('uploads/sekolah/jurusan/' . $row['foto_cover']) ?>"
                                        class="img-fluid w-100"
                                        style="height:200px; object-fit:cover;">

                                    <div class="jurusan-info">
                                        <h5><?= esc($row['nama']) ?></h5>
                                        <small>
                                            <?= lang('App.learn_more') ?>
                                        </small>
                                    </div>

                                </a>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            </div>

        <?php else: ?>

            <div class="text-center">
                <div class="alert alert-info">
                    <?= lang('App.major_not_available') ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
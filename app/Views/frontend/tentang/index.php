<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type      = $context['type'];
$sekolah   = $context['sekolah'] ?? [];
$namaUnit  = $type === 'sekolah'
    ? ($sekolah['nama_sekolah'] ?? 'Sekolah')
    : ($profilYayasan['nama_yayasan'] ?? 'Yayasan');

$baseUpload = $type === 'sekolah'
    ? 'uploads/sekolah/'
    : 'uploads/yayasan/';
?>

<!-- ================= PAGE HEADER ================= -->
<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.profil'),
    'pageTitle' => lang('App.tentang_unit', ['name' => $institutionName])
]) ?>



<!-- ================= ABOUT ================= -->
<section class="about-section">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6" data-animate>
                <h2 class="section-heading">
                    <?= lang('App.tentang_unit', ['name' => $namaUnit]) ?>
                </h2>


                <div class="about-text">
                    <?= $tentang['konten'] ?? '<em>' . lang('App.content_not_available') . '</em>' ?>

                </div>
            </div>

            <div class="col-lg-6 text-center" data-animate>
                <?php if (!empty($tentang['banner_image'])): ?>
                    <img
                        src="<?= base_url($baseUpload . $tentang['banner_image']) ?>"
                        class="about-image"
                        alt="Tentang <?= esc($namaUnit) ?>">
                <?php endif ?>
            </div>

        </div>
    </div>
</section>

<!-- ================= VISI & MISI ================= -->
<?php if (!empty($visiMisi)): ?>
    <section class="vision-section">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-6" data-animate>
                    <div class="vision-card">
                        <h3><?= lang('App.our_vision') ?></h3>

                        <p>
                            <?= esc($visiMisi['visi'] ?? '') ?>
                        </p>
                    </div>
                </div>


                <div class="col-lg-6" data-animate>
                    <div class="vision-card">
                        <h3><?= lang('App.our_mission') ?></h3>
                        <ul>
                            <?php foreach (preg_split('/\r\n|\r|\n/', $visiMisi['misi']) as $misi): ?>
                                <?php if (trim($misi)): ?>
                                    <li><?= esc($misi) ?></li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif ?>

<!-- ================= SEJARAH (YAYASAN ONLY) ================= -->
<?php if ($type === 'yayasan' && !empty($sejarah)): ?>
    <section class="history-section">
        <div class="container">

            <div class="text-center mb-5" data-animate>
                <span class="section-badge"><?= lang('App.history') ?></span>
                <h2 class="section-heading"><?= lang('App.foundation_journey') ?></h2>
            </div>

            <div class="row g-4">
                <?php foreach ($sejarah as $row): ?>
                    <div class="col-md-4" data-animate>
                        <div class="history-card">
                            <span class="history-year"><?= esc($row['tahun']) ?></span>
                            <h5><?= esc($row['judul']) ?></h5>
                            <p><?= esc($row['deskripsi']) ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </section>
<?php endif ?>

<!-- ================= PIMPINAN ================= -->
<?php if (!empty($tentang['pesan_direktur'])): ?>
    <section class="leader-section">
        <div class="container">
            <div class="row align-items-center g-5">

                <?php if (!empty($tentang['foto_direktur'])): ?>
                    <div class="col-lg-4 text-center" data-animate>
                        <img
                            src="<?= base_url($baseUpload . $tentang['foto_direktur']) ?>"
                            class="leader-photo"
                            alt="Pimpinan">
                    </div>
                <?php endif ?>

                <div class="col-lg-8" data-animate>
                    <h4><?= esc($tentang['nama_direktur']) ?></h4>
                    <small class="leader-role">
                        <?= $type === 'sekolah'
                            ? lang('App.principal')
                            : lang('App.foundation_leader') ?>
                    </small>


                    <blockquote>
                        <?= nl2br(esc((string)($tentang['pesan_direktur'] ?? ''))) ?>
                    </blockquote>
                </div>

            </div>
        </div>
    </section>
<?php endif ?>

<!-- ================= STAFF ================= -->
<?php if (!empty($staff)): ?>
    <section class="staff-section">
        <div class="container">

            <div class="text-center mb-5" data-animate>
                <span class="section-badge">
                    <?= $type === 'sekolah'
                        ? lang('App.staff_teacher')
                        : lang('App.leadership_team') ?>
                </span>

                <h2 class="section-heading">
                    <?= $type === 'sekolah'
                        ? lang('App.school_staff')
                        : lang('App.our_people') ?>
                </h2>

            </div>

            <div class="row g-4 justify-content-center">
                <?php foreach ($staff as $row): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6" data-animate>
                        <div class="staff-card">
                            <img
                                src="<?= !empty($row['foto'])
                                            ? base_url('uploads/staff/' . $row['foto'])
                                            : base_url('assets/theme/img/team-1.jpg') ?>"
                                alt="<?= esc($row['nama']) ?>">

                            <div class="staff-info">
                                <h6><?= esc($row['nama']) ?></h6>
                                <span><?= esc($row['jabatan']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </section>
<?php endif ?>

<!-- ================= AKADEMIK (YAYASAN ONLY) ================= -->
<?php if ($type === 'yayasan' && !empty($akademik)): ?>
    <section class="akademik-section">
        <div class="container">

            <div class="text-center mb-5" data-animate>
                <span class="section-badge"><?= lang('App.unit_pendidikan') ?></span>
                <h2 class="section-heading"><?= lang('App.our_schools') ?></h2>

            </div>

            <div class="row g-4 justify-content-center">
                <?php foreach ($akademik as $row): ?>
                    <div class="col-lg-4 col-md-6" data-animate>
                        <div class="akademik-card">
                            <img
                                src="<?= !empty($row['foto_sekolah'])
                                            ? base_url('uploads/akademik/' . $row['foto_sekolah'])
                                            : base_url('assets/theme/img/course-1.jpg') ?>">

                            <div class="akademik-info">
                                <span class="badge"><?= esc($row['jenjang']) ?></span>
                                <h5><?= esc($row['nama_sekolah']) ?></h5>
                                <p><?= esc(word_limiter(strip_tags($row['deskripsi'] ?? ''), 20)) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </section>
<?php endif ?>

<?= $this->endSection() ?>
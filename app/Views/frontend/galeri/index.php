<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type    = $context['type'];
$sekolah = $context['sekolah'] ?? null;

$imgBase = $type === 'sekolah'
    ? 'uploads/sekolah/galeri/'
    : 'uploads/galeri/';
?>

<!-- PAGE HEADER -->
<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.media'),
    'pageTitle' => lang('App.gallery_of', ['name' => $institutionName])
]) ?>

<section class="galeri-section container">

    <?php if (empty($galeri)): ?>
        <div class="galeri-empty" data-animate="fade-up">
            <?= lang('App.gallery_empty') ?>
        </div>
    <?php else: ?>

        <div class="galeri-grid">
            <?php foreach ($galeri as $g): ?>
                <figure class="galeri-card" data-animate="zoom-in">
                    <img
                        src="<?= base_url($imgBase . $g['gambar']) ?>"
                        alt="<?= esc($g['judul']) ?>"
                        data-title="<?= esc($g['judul']) ?>"
                        class="galeri-img"
                        loading="lazy">

                    <figcaption class="galeri-overlay">
                        <span><?= esc($g['judul']) ?></span>
                    </figcaption>
                </figure>
            <?php endforeach ?>
        </div>

    <?php endif ?>

</section>

<!-- LIGHTBOX -->
<div id="galeri-lightbox">
    <span class="gl-close">&times;</span>
    <img src="">
    <div class="gl-caption"></div>
</div>

<?= $this->endSection() ?>
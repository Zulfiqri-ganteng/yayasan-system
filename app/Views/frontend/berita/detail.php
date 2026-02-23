<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type      = $context['type'];
$sekolah   = $context['sekolah'] ?? null;

$judul     = esc($berita['judul']);
$locale    = service('request')->getLocale();

/*
|--------------------------------------------------------------------------
| Localized Date
|--------------------------------------------------------------------------
*/
$timestamp = strtotime($berita['created_at']);

if ($locale === 'id') {
  $formatter = new \IntlDateFormatter(
    'id_ID',
    \IntlDateFormatter::LONG,
    \IntlDateFormatter::NONE
  );
} elseif ($locale === 'zh') {
  $formatter = new \IntlDateFormatter(
    'zh_CN',
    \IntlDateFormatter::LONG,
    \IntlDateFormatter::NONE
  );
} else {
  $formatter = new \IntlDateFormatter(
    'en_US',
    \IntlDateFormatter::LONG,
    \IntlDateFormatter::NONE
  );
}

$tanggal = $formatter->format($timestamp);

/*
|--------------------------------------------------------------------------
| Institution Name
|--------------------------------------------------------------------------
*/
$publisher = $type === 'sekolah'
  ? esc($sekolah['nama_sekolah'] ?? lang('App.school'))
  : esc($profilYayasan['nama_yayasan'] ?? lang('App.foundation'));
?>

<?= view('frontend/partials/page_header', [
  'pageLabel' => lang('App.news_of', ['name' => $institutionName]),
  'pageTitle' => $judul
]) ?>

<!-- ================= CONTENT ================= -->
<section class="berita-detail-section">
  <div class="container">

    <div class="row justify-content-center">
      <div class="col-lg-9">

        <?php if (!empty($berita['gambar'])): ?>
          <div class="berita-hero-image">
            <img
              src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>"
              alt="<?= $judul ?>">
          </div>
        <?php endif ?>

        <article class="berita-detail-content">
          <?= $berita['konten'] ?>
        </article>

        <div class="berita-footer-meta">
          <span><?= $publisher ?></span>
        </div>

      </div>
    </div>

    <div class="berita-meta">
      <?= lang('App.published_on') ?> <?= esc($tanggal) ?>
    </div>

    <br>

    <a href="<?= base_url($type === 'sekolah'
                ? $sekolah['jenjang'] . '/berita'
                : 'berita') ?>"
      class="berita-back-btn">
      ← <?= lang('App.back_to_news') ?>
    </a>

  </div>
  <div class="berita-nav-article">

    <?php if (!empty($prev)): ?>
      <a href="<?= base_url($prev['slug']) ?>" class="article-nav prev-article">
        ← <?= esc($prev['judul']) ?>
      </a>
    <?php endif ?>

    <?php if (!empty($next)): ?>
      <a href="<?= base_url($next['slug']) ?>" class="article-nav next-article">
        <?= esc($next['judul']) ?> →
      </a>
    <?php endif ?>

  </div>

</section>

<?= $this->endSection() ?>
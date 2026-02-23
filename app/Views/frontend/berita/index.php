<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?php
$type    = $context['type'];
$sekolah = $context['sekolah'] ?? null;

$namaUnit = $type === 'sekolah'
  ? ($sekolah['nama_sekolah'] ?? lang('App.school'))
  : ($profilYayasan['nama_yayasan'] ?? lang('App.foundation'));

?>

<!-- ================= HEADER ================= -->
<?= view('frontend/partials/page_header', [
  'pageLabel' => lang('App.informasi'),
  'pageTitle' => lang('App.news_of', ['name' => $namaUnit])
]) ?>

<!-- ================= LIST BERITA ================= -->
<section class="berita-list-section">
  <div class="container">

    <div class="row g-4 justify-content-center">

      <?php if (!empty($berita)): ?>
        <?php foreach ($berita as $row): ?>
          <div class="col-lg-4 col-md-6">
            <div class="berita-card h-100">

              <!-- IMAGE -->
              <div class="berita-image-wrapper">
                <img
                  src="<?= !empty($row['featured_image'])
                          ? base_url('uploads/berita/' . $row['featured_image'])
                          : base_url('theme/img/course-1.jpg') ?>"
                  alt="<?= esc($row['judul']) ?>"
                  class="berita-image">
              </div>

              <!-- CONTENT -->
              <div class="berita-content">

                <span class="berita-date">
                  <?= \CodeIgniter\I18n\Time::parse($row['created_at'])->toLocalizedString('d MMM yyyy') ?>

                </span>

                <h5 class="berita-card-title">
                  <?= esc($row['judul']) ?>
                </h5>

                <p class="berita-excerpt">
                  <?= esc(word_limiter(strip_tags($row['konten']), 22)) ?>
                </p>

                <a href="<?= base_url(
                            $type === 'sekolah'
                              ? $sekolah['jenjang'] . '/berita/' . $row['slug']
                              : 'berita/' . $row['slug']
                          ) ?>"
                  class="berita-readmore">
                  <?= lang('App.read_more') ?> →
                </a>

              </div>

            </div>
          </div>
        <?php endforeach ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info text-center">
            <?= lang('App.no_news_available') ?>
          </div>
        </div>
      <?php endif ?>

    </div>

    <!-- PAGINATION -->
    <?php if (!empty($pager)): ?>
      <div class="berita-pagination">

        <?= $pager->links('default', 'enterprise_full') ?>






      </div>
    <?php endif ?>


  </div>
</section>

<?= $this->endSection() ?>
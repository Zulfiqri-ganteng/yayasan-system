<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<!-- ================= CAROUSEL / HERO ================= -->
<div class="container-fluid p-0 mb-5">
  <div class="owl-carousel header-carousel position-relative">

    <?php if (!empty($home['hero_images'])): ?>
      <?php foreach ($home['hero_images'] as $imgUrl): ?>
        <div class="owl-carousel-item position-relative">
          <img class="img-fluid" src="<?= $imgUrl ?>" alt="Hero">

          <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
            <div class="container">
              <div class="row justify-content-start">
                <div class="col-sm-10 col-lg-8">


                  <h1 class="display-3 text-white animated slideInDown hero-title-combined">
                    <?= esc($home['hero_title'] ?? lang('App.hero_default_title')) ?>

                    <span class="hero-institution">
                      <?= $context['type'] === 'sekolah'
                        ? esc($context['sekolah']['nama_sekolah'])
                        : esc($profilYayasan['nama_yayasan'] ?? lang('App.foundation_default_name'))
                      ?>
                    </span>
                  </h1>

                  <?php if ($context['type'] === 'sekolah'): ?>
                    <a href="<?= $ctxUrl('ppdb') ?>" class="hero-btn hero-btn-gold me-3">
                      <?= lang('App.ppdb_online') ?>

                    </a>
                    <a href="<?= $ctxUrl('tentang') ?>" class="hero-btn hero-btn-outline">
                      <?= lang('App.about_us') ?>

                    </a>
                  <?php endif; ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    <?php else: ?>
      <div class="owl-carousel-item position-relative">
        <img class="img-fluid" src="<?= base_url('assets/img/carousel-1.jpg') ?>" alt="Default Hero">
      </div>
    <?php endif ?>

  </div>
</div>
<!-- ================= END HERO ================= -->



<!-- ================= WHY CHOOSE US (ONLY FOR SCHOOL) ================= -->
<?php if ($context['type'] === 'sekolah'): ?>

  <section class="why-section-ultra">

    <div class="container">

      <!-- HEADER -->
      <div class="why-header text-center">
        <span class="why-subtitle"><?= lang('App.why_choose_us') ?></span>

        <h2 class="why-title">
          <?= lang('App.why_school', ['school' => esc($context['sekolah']['nama_sekolah'])]) ?>

        </h2>
        <p class="why-description">
          <?= lang('App.why_desc') ?>
        </p>

      </div>

      <!-- FEATURE GRID -->
      <div class="row g-4 why-grid">

        <?php
        $why = [
          ['graduation-cap', lang('App.why_academic')],
          ['globe', lang('App.why_facility')],
          ['home', lang('App.why_environment')],
          ['book-open', lang('App.why_teacher')],
        ];

        foreach ($why as $w):
        ?>

          <div class="col-lg-3 col-md-6">
            <div class="why-card-ultra">

              <div class="why-icon-ultra">
                <i class="fa fa-<?= $w[0] ?>"></i>
              </div>

              <h5><?= $w[1] ?></h5>

              <p>
                <?= lang('App.why_text') ?>

              </p>

            </div>
          </div>

        <?php endforeach ?>

      </div>



    </div>

  </section>

<?php endif; ?>

<!-- ================= END WHY CHOOSE US (ONLY FOR SCHOOL) ================= -->

<?php if (!empty($visiMisi)): ?>
  <div class="container-xxl py-5">
    <div class="container">

      <div class="row g-5 align-items-start">

        <!-- LEFT TITLE SIDE -->
        <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
          <h6 class="section-title bg-white text-start text-primary pe-3">
            <?= $type === 'sekolah'
              ? lang('App.school_direction')
              : lang('App.foundation_direction') ?>

          </h6>

          <h2 class="mb-3">
            <?= lang('App.vision_mission') ?>

          </h2>

          <div class="vm-divider mb-4"></div>

          <p class="text-muted">
            <?= $type === 'sekolah'
              ? lang('App.school_direction_desc')
              : lang('App.foundation_direction_desc') ?>

          </p>
        </div>

        <!-- RIGHT CONTENT SIDE -->
        <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.3s">

          <div class="vm-box">

            <!-- VISION -->
            <div class="vm-item">
              <div class="vm-icon">
                <i class="fa fa-eye"></i>
              </div>

              <div>
                <h5 class="vm-title"><?= lang('App.our_vision') ?>
                </h5>
                <p class="vm-text mb-0">
                  <?= esc($visiMisi['visi']) ?>
                </p>
              </div>
            </div>

            <div class="vm-separator"></div>

            <!-- MISSION -->
            <div class="vm-item">
              <div class="vm-icon">
                <i class="fa fa-bullseye"></i>
              </div>

              <div>
                <h5 class="vm-title"><?= lang('App.our_mission') ?>
                </h5>

                <ul class="vm-list">
                  <?php foreach (preg_split('/\r\n|\r|\n/', $visiMisi['misi']) as $misi): ?>
                    <?php if (trim($misi)): ?>
                      <li>
                        <span class="vm-check">
                          <i class="fa fa-check"></i>
                        </span>
                        <?= esc($misi) ?>
                      </li>
                    <?php endif ?>
                  <?php endforeach ?>
                </ul>

              </div>
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>
<?php endif ?>


<!-- ================= END VISION & MISSION ================= -->

<?php
if ($type === 'sekolah') {
  $aboutImage = !empty($tentang['banner_image'])
    ? base_url('uploads/sekolah/' . $tentang['banner_image'])
    : base_url('assets/theme/img/about.jpg');
} else {
  $aboutImage = !empty($tentang['banner_image'])
    ? base_url('uploads/yayasan/' . $tentang['banner_image'])
    : base_url('assets/theme/img/about.jpg');
}
?>

<!-- ================= ABOUT US ULTRA ================= -->
<div class="container-xxl about-ultra-section">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- IMAGE SIDE -->
      <div class="col-lg-6 position-relative wow fadeInUp" data-wow-delay="0.1s">

        <div class="about-image-wrapper">

          <img src="<?= $aboutImage ?>"
            class="img-fluid about-image"
            alt="About">

          <div class="about-image-accent"></div>

        </div>

      </div>

      <!-- CONTENT SIDE -->
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">

        <span class="about-label">
          <?= $type === 'sekolah'
            ? lang('App.about_school')
            : lang('App.about_foundation') ?>

        </span>

        <h2 class="about-title">
          <?php if ($type === 'sekolah'): ?>
            <?= lang('App.shaping_leaders') ?>
            <br>
            <span><?= esc($context['sekolah']['nama_sekolah'] ?? lang('App.school_default_name')) ?></span>

          <?php else: ?>
            <?= lang('App.empowering_education') ?>
            <br>
            <span><?= esc($profilYayasan['nama_yayasan']) ?></span>
          <?php endif ?>
        </h2>

        <div class="about-divider"></div>

        <p class="about-text">
          <?php if ($type === 'sekolah'): ?>
            <?= esc($tentang['konten'] ?? lang('App.profile_not_available')) ?>
          <?php else: ?>
            <?= esc($profilYayasan['deskripsi_singkat']) ?>
          <?php endif ?>
        </p>

        <?php if (!empty($tentang['konten'])): ?>
          <p class="about-text-secondary">
            <?= esc(word_limiter(strip_tags($tentang['konten']), 35)) ?>
          </p>
        <?php endif ?>

        <a href="<?= $ctxUrl('tentang') ?>" class="about-btn">
          <?= lang('App.discover_more') ?>

        </a>

      </div>

    </div>
  </div>
</div>
<!-- ================= END ABOUT US ================= -->
<?php if ($context['type'] === 'sekolah' && !empty($jurusanHome)): ?>

  <section class="home-jurusan-section py-5 bg-white">
    <div class="container">

      <!-- HEADER -->
      <div class="text-center mb-5">
        <h6 class="section-subtitle"><?= lang('App.program_keahlian') ?>
        </h6>
        <h2 class="section-title"><?= lang('App.featured_major') ?>
        </h2>
        <p class="section-desc">
          <?= lang('App.major_desc') ?>

        </p>
      </div>

      <div class="row g-4">

        <?php foreach ($jurusanHome as $row): ?>

          <div class="col-lg-4 col-md-6">
            <div class="jurusan-premium-card h-100">

              <!-- IMAGE -->
              <div class="jurusan-image-wrapper">
                <img src="<?= base_url('uploads/sekolah/jurusan/' . $row['foto_cover']) ?>"
                  alt="<?= esc($row['nama']) ?>">

                <div class="jurusan-overlay">
                  <a href="<?= $ctxUrl('jurusan/' . $row['slug']) ?>"
                    class="jurusan-btn">
                    <?= lang('App.learn_more') ?>

                  </a>
                </div>
              </div>

              <!-- CONTENT -->
              <div class="jurusan-content">
                <span class="jurusan-badge"><?= lang('App.competency') ?>
                </span>
                <h5><?= esc($row['nama']) ?></h5>
              </div>

            </div>
          </div>

        <?php endforeach ?>

      </div>

      <div class="text-center mt-5">
        <a href="<?= $ctxUrl('jurusan') ?>" class="btn btn-primary px-4 py-2">
          <?= lang('App.view_all_major') ?>

        </a>
      </div>

    </div>
  </section>
  <style>
    .section-subtitle {
      font-size: 14px;
      letter-spacing: 2px;
      color: #00bcd4;
      font-weight: 600;
    }

    .section-title {
      font-weight: 700;
      margin-bottom: 10px;
    }

    .section-desc {
      color: #6c757d;
      max-width: 600px;
      margin: auto;
    }

    .jurusan-premium-card {
      border-radius: 18px;
      overflow: hidden;
      background: #fff;
      transition: all .35s ease;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
      display: flex;
      flex-direction: column;
    }

    .jurusan-premium-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, .12);
    }

    .jurusan-image-wrapper {
      position: relative;
      overflow: hidden;
    }

    .jurusan-image-wrapper img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      transition: .6s ease;
    }

    .jurusan-premium-card:hover img {
      transform: scale(1.08);
    }

    .jurusan-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, .55);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: .4s ease;
    }

    .jurusan-premium-card:hover .jurusan-overlay {
      opacity: 1;
    }

    .jurusan-btn {
      background: #00bcd4;
      color: #fff;
      padding: 10px 22px;
      border-radius: 50px;
      font-size: 14px;
      text-decoration: none;
      transition: .3s;
    }

    .jurusan-btn:hover {
      background: #0097a7;
      color: #fff;
    }

    .jurusan-content {
      padding: 20px;
      text-align: center;
      flex-grow: 1;
    }

    .jurusan-content h5 {
      font-weight: 600;
      margin-top: 10px;
    }

    .jurusan-badge {
      font-size: 12px;
      letter-spacing: 1px;
      color: #00bcd4;
      font-weight: 600;
    }
  </style>
<?php endif; ?>




<!-- ================= FACILITIES ================= -->
<?php if (!empty($fasilitas)): ?>
  <div class="container-xxl py-5 category">
    <div class="container">

      <div class="text-center wow fadeInUp">
        <h6 class="section-title bg-white text-primary px-3"><?= lang('App.facilities') ?>
        </h6>
        <h1 class="mb-5"><?= lang('App.our_facilities') ?>
        </h1>
      </div>

      <div class="row g-3">
        <?php foreach (array_slice($fasilitas, 0, 4) as $i => $f): ?>
          <div class="<?= $i === 0 ? 'col-lg-7' : 'col-lg-5' ?> wow zoomIn">
            <a href="javascript:void(0);"
              class="position-relative d-block overflow-hidden facility-item"
              data-image="<?= base_url('uploads/fasilitas/' . $f['gambar']) ?>"
              data-title="<?= esc($f['nama_fasilitas']) ?>"
              data-desc="<?= esc($f['deskripsi']) ?>">

              <img class="img-fluid w-100"
                src="<?= base_url('uploads/fasilitas/' . $f['gambar']) ?>"
                alt="<?= esc($f['nama_fasilitas']) ?>"
                style="object-fit:cover;min-height:260px">

              <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3">
                <h5 class="m-0"><?= esc($f['nama_fasilitas']) ?></h5>
                <small class="text-primary">
                  <?= esc(word_limiter($f['deskripsi'], 5)) ?>
                </small>
              </div>

            </a>
          </div>
        <?php endforeach ?>
      </div>

    </div>
  </div>
  <div class="facility-lightbox" id="facilityLightbox">
    <div class="facility-lightbox-close">&times;</div>

    <div class="facility-lightbox-content">
      <img src="" alt="">
      <div class="facility-lightbox-body text-center">
        <h4></h4>
        <p class="text-muted"></p>
      </div>
    </div>
  </div>
<?php endif ?>
<!-- ================= END FACILITIES ================= -->



<!-- ================= STAFF PREMIUM ================= -->
<!-- ================= STAFF STYLE ELEARNING ================= -->
<?php if (!empty($staff)): ?>
  <div class="container-xxl py-5 staff-section">
    <div class="container">

      <!-- HEADER -->
      <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">
          <?= $context['type'] === 'sekolah'
            ? lang('App.educators')
            : lang('App.foundation_management') ?>

        </h6>
        <h1 class="mb-5">
          <?= $context['type'] === 'sekolah'
            ? lang('App.professional_staff')
            : lang('App.foundation_management_title') ?>
        </h1>
      </div>

      <div class="row g-4">

        <?php foreach ($staff as $index => $row): ?>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.<?= ($index + 1) ?>s">

            <div class="team-item bg-light staff-card">

              <!-- IMAGE CLICKABLE -->
              <div class="overflow-hidden staff-image"
                data-index="<?= $index ?>">

                <img class="img-fluid"
                  src="<?= !empty($row['foto'])
                          ? base_url('uploads/staff/' . $row['foto'])
                          : base_url('theme/img/default-user.png') ?>"
                  alt="<?= esc($row['nama']) ?>">

              </div>

              <!-- SOCIAL FLOAT -->
              <div class="position-relative d-flex justify-content-center"
                style="margin-top:-23px; z-index:2;">

                <div class="bg-light d-flex justify-content-center pt-2 px-1 shadow-sm">

                  <?php if (!empty($row['facebook'])): ?>
                    <a class="btn btn-sm-square btn-primary mx-1"
                      href="<?= esc($row['facebook']) ?>"
                      target="_blank">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                  <?php endif; ?>

                  <?php if (!empty($row['instagram'])): ?>
                    <a class="btn btn-sm-square btn-primary mx-1"
                      href="<?= esc($row['instagram']) ?>"
                      target="_blank">
                      <i class="fab fa-instagram"></i>
                    </a>
                  <?php endif; ?>

                  <?php if (!empty($row['linkedin'])): ?>
                    <a class="btn btn-sm-square btn-primary mx-1"
                      href="<?= esc($row['linkedin']) ?>"
                      target="_blank">
                      <i class="fab fa-linkedin-in"></i>
                    </a>
                  <?php endif; ?>

                </div>
              </div>

              <!-- CONTENT -->
              <div class="text-center p-4">

                <h5 class="mb-0"><?= esc($row['nama']) ?></h5>

                <small class="text-muted d-block">
                  <?= esc($row['jabatan']) ?>
                </small>

                <?php if (!empty($row['wali_kelas'])): ?>
                  <div class="mt-1 small text-warning">
                    <i class="fa fa-chalkboard-teacher me-1"></i>
                    <?= lang('App.homeroom_teacher') ?>
                    <?= esc($row['wali_kelas']) ?>
                  </div>
                <?php endif; ?>

              </div>

            </div>

          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>


  <!-- STAFF LIGHTBOX -->
  <div class="staff-lightbox" id="staffLightbox">

    <div class="staff-lightbox-inner">

      <span class="staff-close">&times;</span>

      <img class="staff-lightbox-img" src="">

      <div class="staff-lightbox-caption">
        <h5 id="lightboxName"></h5>
        <p id="lightboxRole"></p>
        <span id="lightboxCounter"></span>
      </div>

      <span class="staff-prev">
        <i class="fas fa-chevron-left"></i>
      </span>

      <span class="staff-next">
        <i class="fas fa-chevron-right"></i>
      </span>


    </div>

  </div>


<?php endif; ?>
<!-- ================= END STAFF ================= -->



<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnShowAllStaff');
    if (!btn) return;

    btn.addEventListener('click', function() {
      document.querySelectorAll('.staff-hidden').forEach(el => {
        el.classList.remove('d-none');
      });
      btn.remove();
    });
  });
</script>




<!-- ================= LATEST NEWS PREMIUM ================= -->
<?php if (!empty($beritaTerbaru)): ?>
  <section class="news-section">
    <div class="container">

      <!-- HEADER -->
      <div class="text-center mb-5">
        <span class="section-badge"><?= lang('App.latest_update') ?></span>

        <h2 class="section-title"><?= lang('App.latest_news') ?></h2>

        <div class="section-divider"></div>
      </div>

      <div class="news-wrapper">

        <div class="news-slider">

          <?php foreach ($beritaTerbaru as $row): ?>
            <div class="news-item">

              <div class="news-card">

                <!-- IMAGE -->
                <div class="news-image">

                  <img
                    src="<?= !empty($row['featured_image'])
                            ? base_url('uploads/berita/' . $row['featured_image'])
                            : base_url('assets/theme/img/testimonial-1.jpg') ?>"
                    alt="<?= esc($row['judul']) ?>">

                  <!-- CATEGORY BADGE -->
                  <span class="news-category">
                    <?= esc($row['kategori'] ?? lang('App.news')) ?>

                  </span>

                  <!-- OVERLAY -->
                  <div class="news-overlay">
                    <a href="<?= $ctxUrl('berita/' . $row['slug']) ?>" class="overlay-btn">
                      <?= lang('App.read_more') ?>

                    </a>
                  </div>

                </div>

                <!-- CONTENT -->
                <div class="news-body">

                  <div class="news-date">
                    <i class="fa fa-calendar-alt"></i>
                    <?= \CodeIgniter\I18n\Time::parse($row['created_at'])
                      ->toLocalizedString('d MMM yyyy') ?>

                  </div>

                  <h5 class="news-title">
                    <?= esc(word_limiter($row['judul'], 10)) ?>
                  </h5>

                  <p class="news-excerpt">
                    <?= esc(word_limiter(strip_tags($row['konten']), 18)) ?>
                  </p>

                </div>

              </div>

            </div>
          <?php endforeach ?>

        </div>

      </div>

      <!-- VIEW ALL -->
      <div class="text-center mt-5">
        <a href="<?= $ctxUrl('berita') ?>" class="btn btn-primary px-4 py-2">
          <?= lang('App.view_all_news') ?>

        </a>
      </div>

    </div>
  </section>
<?php endif; ?>





<?= $this->endSection() ?>
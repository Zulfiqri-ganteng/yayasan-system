<?php
$type    = $context['type'];
$sekolah = $context['sekolah'] ?? null;
$jenjang = $sekolah['jenjang'] ?? null;

$profilAktif = $profil
  ?? ($type === 'sekolah'
    ? ($profilSekolah ?? [])
    : ($profilYayasan ?? []));

$nama = $type === 'sekolah'
  ? ($profilAktif['nama_sekolah'] ?? lang('App.school'))
  : ($profilAktif['nama_yayasan'] ?? lang('App.foundation'));

$logoPath = $type === 'sekolah'
  ? 'uploads/logo/' . ($profilAktif['logo'] ?? '')
  : 'uploads/yayasan/' . ($profilAktif['logo'] ?? '');
?>

<footer class="footer-ultra">

  <div class="footer-container">

    <!-- ================= BRAND ================= -->
    <div class="footer-brand">

      <div class="footer-brand-header">
        <?php if (!empty($profilAktif['logo'])): ?>
          <img src="<?= base_url($logoPath) ?>"
            alt="Logo"
            class="footer-logo">
        <?php endif; ?>

        <h3><?= esc($nama) ?></h3>
      </div>

      <div class="footer-contact">
        <span><i class="fa fa-map-marker-alt"></i> <?= esc($profilAktif['alamat'] ?? '-') ?></span>
        <span><i class="fa fa-phone"></i> <?= esc($profilAktif['no_telp'] ?? $profilAktif['telepon'] ?? '-') ?></span>
        <span><i class="fa fa-envelope"></i> <?= esc($profilAktif['email'] ?? '-') ?></span>
      </div>

    </div>

    <!-- ================= QUICK LINKS ================= -->
    <div class="footer-links">
      <h4><?= lang('App.quick_links') ?></h4>

      <?php if ($type === 'yayasan'): ?>
        <a href="<?= base_url('/') ?>"><?= lang('App.home') ?></a>
        <a href="<?= base_url('tentang') ?>"><?= lang('App.profil') ?></a>
        <a href="<?= base_url('berita') ?>"><?= lang('App.berita') ?></a>
        <a href="<?= base_url('kontak') ?>"><?= lang('App.kontak') ?></a>
      <?php else: ?>
        <a href="<?= base_url($jenjang) ?>"><?= lang('App.home') ?></a>
        <a href="<?= base_url("$jenjang/tentang") ?>"><?= lang('App.profil') ?></a>
        <a href="<?= base_url("$jenjang/berita") ?>"><?= lang('App.berita') ?></a>
        <a href="<?= base_url("$jenjang/kontak") ?>"><?= lang('App.kontak') ?></a>
      <?php endif ?>

    </div>

    <!-- ================= CTA ================= -->
    <div class="footer-cta">
      <h4><?= lang('App.register_now') ?></h4>
      <p><?= lang('App.register_desc') ?></p>

      <?php if ($type === 'sekolah'): ?>
        <a href="<?= base_url("$jenjang/ppdb") ?>" class="footer-btn">
          <?= lang('App.ppdb_online') ?>
        </a>
      <?php endif; ?>
    </div>

  </div>

  <!-- ================= COPYRIGHT ================= -->
  <div class="footer-bottom">
    <div class="footer-bottom-inner">
      <span>
        © <?= date('Y') ?> <?= esc($nama) ?>.
        <?= lang('App.all_rights_reserved') ?>
      </span>

      <a href="https://www.instagram.com/zufieee"
        target="_blank"
        class="designer-link">
        Design by <strong>Zulfiqri S.Kom</strong>
      </a>
    </div>
  </div>

</footer>
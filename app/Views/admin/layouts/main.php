<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Admin Panel') ?></title>

  <!-- BASE -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/typicons/typicons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/admin/css/sidebar_admin_sekolah.css') ?>">

  <link rel="shortcut icon" href="<?= base_url('assets/admin/images/favicon.ico') ?>">
</head>

<body class="<?= session('role') === 'superadmin' ? 'theme-yayasan' : 'theme-sekolah' ?>">

  <div class="container-scroller">

    <?= view('admin/partials/navbar') ?>

    <div class="container-fluid page-body-wrapper">

      <?php if (session('role') === 'superadmin'): ?>
        <?= view('admin/partials/sidebar') ?>
      <?php else: ?>
        <?= view('admin/partials/sidebar_admin_sekolah') ?>
      <?php endif ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <?= $this->renderSection('content') ?>
        </div>

        <?= view('admin/partials/footer') ?>
      </div>

    </div>
  </div>

  <!-- BASE JS -->
  <script src="<?= base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>

  <!-- TEMPLATE JS (JANGAN DIHAPUS) -->
  <script src="<?= base_url('assets/admin/js/off-canvas.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/hoverable-collapse.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/template.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/settings.js') ?>"></script>
  <script src="<?= base_url('assets/admin/js/todolist.js') ?>"></script>
  <?php
  $googleMapsKey = env('google.maps.key');
  ?>

  <?php if (!empty($googleMapsKey)): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= esc($googleMapsKey) ?>"></script>
  <?php endif; ?>

</body>

</html>
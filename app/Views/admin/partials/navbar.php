<?php
$role = session()->get('role');

$dashboardUrl = $role === 'superadmin'
  ? base_url('admin/dashboard')
  : base_url('sekolah/dashboard');

$nama = $role === 'superadmin'
  ? ($profilYayasan['nama_yayasan'] ?? 'Yayasan')
  : ($profilSekolah['nama_sekolah'] ?? 'Sekolah');

// Inisial untuk avatar
$inisial = strtoupper(substr($nama, 0, 1));

// Tanggal hari ini untuk display
$tanggal = date('M d');
?>

<!-- Navbar utama - persis struktur original -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <!-- LEFT: BRAND + TOGGLE (DESKTOP MINIMIZE) -->
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <!-- Logo besar (desktop) -->
      <a class="navbar-brand brand-logo" href="<?= $dashboardUrl ?>">
        <!-- Ganti dengan logo jika ada, jika tidak pakai teks -->
        <!-- <span class="brand-text" style="font-weight: 700; color: #4b49ac;">S</span> -->
      </a>
      <!-- Logo kecil (saat sidebar mini) -->
      <!-- <a class="navbar-brand brand-logo-mini" href="<?= $dashboardUrl ?>">
        <span class="brand-text" style="font-weight: 700; color: #4b49ac;">S</span>
      </a> -->
      <!-- Tombol toggle untuk minimize sidebar (desktop) -->
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" id="toggleSidebar" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </div>

  <!-- RIGHT: MENU WRAPPER (PROFILE, ICON, NOTIF) -->
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <!-- Profile & status (kiri dalam menu) -->
    <ul class="navbar-nav me-lg-2">
      <!-- Profile dropdown -->
      <li class="nav-item nav-profile dropdown">
        <!-- <a class="nav-link" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <div class="profile-circle" style="width: 36px; height: 36px; background: #4b49ac; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 8px;">
            <?= $inisial ?>
          </div>
          <span class="nav-profile-name"><?= esc($nama) ?></span>
        </a> -->
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="<?= $dashboardUrl ?>">
            <i class="typcn typcn-home-outline"></i> Dashboard
          </a>
          <a class="dropdown-item" href="#">
            <i class="typcn typcn-cog-outline text-primary"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
            <i class="typcn typcn-power"></i> Logout
          </a>
        </div>
      </li>
      <!-- Status last login (bisa disesuaikan) -->
      <!-- <li class="nav-item nav-user-status dropdown">
        <p class="mb-0">Last login: <?= session()->get('last_login') ?? 'today' ?></p>
      </li> -->
    </ul>

    <!-- Ikon menu kanan (date, message, notification) -->
    <ul class="navbar-nav navbar-nav-right">


      <!-- Message dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
          <i class="typcn typcn-mail mx-0"></i>
          <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <p class="mb-0 fw-normal float-start dropdown-header">Messages</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="profile-circle" style="width: 32px; height: 32px; background: #e0e0e0; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                JD
              </div>
            </div>
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis fw-normal">John Doe</h6>
              <p class="fw-light small-text text-muted mb-0">Meeting at 10 AM</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="profile-circle" style="width: 32px; height: 32px; background: #e0e0e0; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                AS
              </div>
            </div>
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis fw-normal">Admin</h6>
              <p class="fw-light small-text text-muted mb-0">New user registered</p>
            </div>
          </a>
        </div>
      </li>

      <!-- Notification dropdown -->
      <li class="nav-item dropdown me-0">
        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="typcn typcn-bell mx-0"></i>
          <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 fw-normal float-start dropdown-header">Notifications</p>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="typcn typcn-info mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal">Application Update</h6>
              <p class="fw-light small-text mb-0 text-muted">Just now</p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="typcn typcn-cog-outline mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject fw-normal">Settings</h6>
              <p class="fw-light small-text mb-0 text-muted">2 hours ago</p>
            </div>
          </a>
        </div>
      </li>
      <!-- Profile dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center"
          href="#"
          id="profileDropdown"
          data-bs-toggle="dropdown"
          aria-expanded="false">

          <div class="profile-circle">
            <?= strtoupper(substr(session()->get('nama') ?? '', 0, 1)) ?>
          </div>

        </a>

        <div class="dropdown-menu dropdown-menu-end navbar-dropdown"
          aria-labelledby="profileDropdown">

        

          <div class="dropdown-divider"></div>

          <a class="dropdown-item" href="<?= base_url('profile') ?>">
            <i class="typcn typcn-user-outline me-2"></i> Profile
          </a>

          <a class="dropdown-item" href="<?= base_url('ganti-password') ?>">
            <i class="typcn typcn-key-outline me-2"></i> Ganti Password
          </a>

          <div class="dropdown-divider"></div>

          <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
            <i class="typcn typcn-power-outline me-2"></i> Logout
          </a>

        </div>
      </li>
    </ul>
    <!-- Tombol toggle untuk offcanvas (mobile) -->
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="typcn typcn-th-menu"></span>
    </button>
  </div>
</nav>

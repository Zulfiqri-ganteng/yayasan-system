<?php
$segment = service('uri')->getPath();
$systemActive = menu_active([
  'admin/yayasan/system/orphan-files',
  'admin/yayasan/system/backup'
], 'admin/yayasan/system');

// Helper untuk submenu CMS Yayasan
$cmsActive = menu_active([
  'admin/yayasan/home',
  'admin/yayasan/tentang',
  'admin/yayasan/sejarah',
  'admin/yayasan/staff',
  'admin/yayasan/visi-misi',
  'admin/yayasan/berita',
  'admin/yayasan/galeri',
], 'admin');
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-scroll" style="height: 100%; overflow-y: auto;">

    <!-- ===== USER PROFILE (Superadmin) ===== -->
    <div class="user-profile" data-title="<?= esc($profilYayasan['nama_yayasan'] ?? 'Superadmin') ?>">
      <div class="user-avatar">
        <i class="typcn typcn-user-outline"></i>
      </div>
      <div class="user-info">
        <h5 class="user-name"><?= esc($profilYayasan['nama_yayasan'] ?? 'Superadmin') ?></h5>
        <span class="user-role">Super Administrator</span>
      </div>
    </div>

    <ul class="nav pt-2">

      <!-- DASHBOARD -->
      <li class="nav-item <?= menu_active('admin/dashboard') ?>" data-title="Dashboard">
        <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
          <i class="typcn typcn-device-desktop menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <!-- YAYASAN -->
      <li class="nav-item <?= menu_active('admin/yayasan/profil') ?>" data-title="Profil Yayasan">
        <a class="nav-link" href="<?= base_url('admin/yayasan/profil') ?>">
          <i class="typcn typcn-briefcase menu-icon"></i>
          <span class="menu-title">Profil Yayasan</span>
        </a>
      </li>

      <li class="nav-item <?= menu_active('admin/yayasan/akademik') ?>" data-title="Akademik Yayasan">
        <a class="nav-link" href="<?= base_url('admin/yayasan/akademik') ?>">
          <i class="typcn typcn-mortar-board menu-icon"></i>
          <span class="menu-title">Akademik Yayasan</span>
        </a>
      </li>

      <!-- WEBSITE YAYASAN (COLLAPSE) -->
      <li class="nav-item <?= $cmsActive ? 'active' : '' ?>" data-title="Website Yayasan">
        <a class="nav-link" data-bs-toggle="collapse" href="#cmsYayasan"
          aria-expanded="<?= $cmsActive ? 'true' : 'false' ?>" aria-controls="cmsYayasan">
          <i class="typcn typcn-world-outline menu-icon"></i>
          <span class="menu-title">Website Yayasan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse <?= $cmsActive ? 'show' : '' ?>" id="cmsYayasan">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item <?= menu_active('admin/yayasan/home') ?>" data-title="Beranda">
              <a class="nav-link" href="<?= base_url('admin/yayasan/home') ?>">Beranda</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/tentang') ?>" data-title="Tentang">
              <a class="nav-link" href="<?= base_url('admin/yayasan/tentang') ?>">Tentang</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/sejarah') ?>" data-title="Sejarah">
              <a class="nav-link" href="<?= base_url('admin/yayasan/sejarah') ?>">Sejarah</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/staff') ?>" data-title="Staff">
              <a class="nav-link" href="<?= base_url('admin/yayasan/staff') ?>">Staff</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/visi-misi') ?>" data-title="Visi & Misi">
              <a class="nav-link" href="<?= base_url('admin/yayasan/visi-misi') ?>">Visi & Misi</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/berita') ?>" data-title="Berita">
              <a class="nav-link" href="<?= base_url('admin/yayasan/berita') ?>">Berita</a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/galeri') ?>" data-title="Galeri">
              <a class="nav-link" href="<?= base_url('admin/yayasan/galeri') ?>">Galeri</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- DATA SEKOLAH -->
      <li class="nav-item <?= menu_active('admin/sekolah') ?>" data-title="Data Sekolah">
        <a class="nav-link" href="<?= base_url('admin/sekolah') ?>">
          <i class="typcn typcn-th-large-outline menu-icon"></i>
          <span class="menu-title">Data Sekolah</span>
        </a>
      </li>

      <!-- ADMIN SEKOLAH -->
      <li class="nav-item <?= menu_active('admin/users') ?>" data-title="Admin Sekolah">
        <a class="nav-link" href="<?= base_url('admin/users') ?>">
          <i class="typcn typcn-user-add-outline menu-icon"></i>
          <span class="menu-title">Admin Sekolah</span>
        </a>
      </li>

      <!-- MASTER FITUR -->
      <li class="nav-item <?= menu_active('admin/fitur') ?>" data-title="Master Fitur">
        <a class="nav-link" href="<?= base_url('admin/fitur') ?>">
          <i class="typcn typcn-puzzle-outline menu-icon"></i>
          <span class="menu-title">Master Fitur</span>
        </a>
      </li>

      <!-- SYSTEM TOOLS (COLLAPSE) -->
      <li class="nav-item <?= $systemActive ? 'active' : '' ?>" data-title="System Tools">
        <a class="nav-link" data-bs-toggle="collapse" href="#systemTools"
          aria-expanded="<?= $systemActive ? 'true' : 'false' ?>" aria-controls="systemTools">
          <i class="typcn typcn-cog-outline menu-icon"></i>
          <span class="menu-title">System Tools</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse <?= $systemActive ? 'show' : '' ?>" id="systemTools">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item <?= menu_active('admin/yayasan/system/orphan-files') ?>" data-title="Orphan Files">
              <a class="nav-link" href="<?= base_url('admin/yayasan/system/orphan-files') ?>">
                🧹 Orphan File Cleaner
              </a>
            </li>
            <li class="nav-item <?= menu_active('admin/yayasan/system/backup') ?>" data-title="Backup & Restore">
              <a class="nav-link" href="<?= base_url('admin/yayasan/system/backup') ?>">
                💾 Backup & Restore
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- LOGOUT -->
      <li class="nav-item mt-4" data-title="Logout">
        <a class="nav-link" href="<?= base_url('logout') ?>">
          <i class="typcn typcn-power menu-icon text-danger"></i>
          <span class="menu-title text-danger">Logout</span>
        </a>
      </li>

    </ul>
  </div>
</nav>

<!-- Script toggle mini sidebar (sama seperti aslinya) -->
<script>
  (function() {
    const btn = document.getElementById('toggleSidebar');
    if (!btn) return;

    if (localStorage.getItem('sidebarMini') === '1') {
      document.body.classList.add('sidebar-mini');
    }

    btn.addEventListener('click', function() {
      document.body.classList.toggle('sidebar-mini');
      localStorage.setItem(
        'sidebarMini',
        document.body.classList.contains('sidebar-mini') ? '1' : '0'
      );
    });
  })();
</script>
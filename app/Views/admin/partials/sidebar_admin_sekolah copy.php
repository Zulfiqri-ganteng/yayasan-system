<?php
$segment = service('uri')->getSegment(2);
$active  = fn($s) => $segment === $s ? 'active' : '';

$cmsActive = menu_active([
  'sekolah/home',
  'sekolah/tentang',
  'sekolah/visi-misi',
  'sekolah/fasilitas',
  'sekolah/staff',
  'sekolah/berita',
  'sekolah/galeri',
  'sekolah/pengumuman'
], 'sekolah');

$masterActive = in_array($segment, ['siswa', 'guru', 'jurusan']);
$akademikActive = in_array($segment, ['jadwal-pelajaran', 'rapor']);
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-scroll" style="height: 100%; overflow-y: auto;">

    <!-- ========== USER CONTEXT (lebih modern) ========== -->
    <div class="user-profile">
      <div class="user-avatar">
        <i class="typcn typcn-home-outline"></i>
      </div>
      <div class="user-info">
        <h5 class="user-name"><?= esc($profilSekolah['nama_sekolah'] ?? 'Sekolah') ?></h5>
        <span class="user-role">Admin Sekolah</span>
      </div>
    </div>

    <ul class="nav pt-2">

      <!-- ========== UTAMA ========== -->
      <?php if (school_has_feature('dashboard')): ?>
        <li class="nav-category">Utama</li>
        <li class="nav-item <?= $active('dashboard') ?>" data-title="Dashboard">
          <a class="nav-link" href="<?= base_url('sekolah/dashboard') ?>">
            <i class="typcn typcn-device-desktop menu-icon"></i>
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if (school_has_feature('profil_sekolah')): ?>
        <li class="nav-item <?= $active('profil') ?>" data-title="Profil Sekolah">
          <a class="nav-link" href="<?= base_url('sekolah/profil') ?>">
            <i class="typcn typcn-home-outline menu-icon"></i>
            <span class="menu-title">Profil Sekolah</span>
          </a>
        </li>
      <?php endif; ?>

      <?php if (school_has_feature('ppdb')): ?>
        <li class="nav-item <?= $active('ppdb') ?>" data-title="PPDB">
          <a class="nav-link" href="<?= base_url('sekolah/ppdb') ?>">
            <i class="typcn typcn-document-text menu-icon"></i>
            <span class="menu-title">PPDB</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- ========== MASTER DATA ========== -->
      <?php if (
        school_has_feature('akun_siswa') ||
        school_has_feature('akun_guru')
      ): ?>
        <li class="nav-category">Master Data</li>

        <li class="nav-item" data-title="Data Sekolah">
          <a class="nav-link" data-bs-toggle="collapse" href="#masterDataSekolah"
            aria-expanded="<?= $masterActive ? 'true' : 'false' ?>">
            <i class="typcn typcn-database menu-icon"></i>
            <span class="menu-title">Data Sekolah</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse <?= $masterActive ? 'show' : '' ?>" id="masterDataSekolah">
            <ul class="nav flex-column sub-menu">
              <?php if (school_has_feature('akun_siswa')): ?>
                <li class="nav-item <?= $active('siswa') ?>" data-title="Data Siswa">
                  <a class="nav-link" href="<?= base_url('sekolah/siswa') ?>">Data Siswa</a>
                </li>
              <?php endif; ?>
              <?php if (school_has_feature('akun_guru')): ?>
                <li class="nav-item <?= $active('guru') ?>" data-title="Data Guru">
                  <a class="nav-link" href="<?= base_url('sekolah/guru') ?>">Data Guru</a>
                </li>
              <?php endif; ?>

            </ul>
          </div>
        </li>
      <?php endif; ?>

      <!-- ========== AKADEMIK ========== -->
      <?php if (
        school_has_feature('jadwal_pelajaran') ||
        school_has_feature('nilai_rapor')
      ): ?>
        <li class="nav-category">Akademik</li>

        <li class="nav-item" data-title="Akademik">
          <a class="nav-link" data-bs-toggle="collapse" href="#akademikSekolah"
            aria-expanded="<?= $akademikActive ? 'true' : 'false' ?>">
            <i class="typcn typcn-book menu-icon"></i>
            <span class="menu-title">Akademik</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse <?= $akademikActive ? 'show' : '' ?>" id="akademikSekolah">
            <ul class="nav flex-column sub-menu">
              <?php if (school_has_feature('jadwal_pelajaran')): ?>
                <li class="nav-item <?= $active('jadwal-pelajaran') ?>" data-title="Jadwal Pelajaran">
                  <a class="nav-link" href="<?= base_url('sekolah/jadwal-pelajaran') ?>">Jadwal Pelajaran</a>
                </li>
              <?php endif; ?>
              <?php if (school_has_feature('nilai_rapor')): ?>
                <li class="nav-item <?= $active('rapor') ?>" data-title="Rapor">
                  <a class="nav-link" href="<?= base_url('sekolah/rapor') ?>">Rapor</a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </li>
      <?php endif; ?>
      <?php if (
        school_has_feature('ekstrakurikuler') ||
        school_has_feature('osis')
      ): ?>

        <li class="nav-category">Kesiswaan</li>

        <li class="nav-item" data-title="Kesiswaan">
          <a class="nav-link" data-bs-toggle="collapse" href="#kesiswaanMenu"
            aria-expanded="<?= in_array($segment, ['ekstrakurikuler', 'osis']) ? 'true' : 'false' ?>">
            <i class="typcn typcn-group-outline menu-icon"></i>
            <span class="menu-title">Kesiswaan</span>
            <i class="menu-arrow"></i>
          </a>

          <div class="collapse <?= in_array($segment, ['ekstrakurikuler', 'osis']) ? 'show' : '' ?>" id="kesiswaanMenu">
            <ul class="nav flex-column sub-menu">

              <?php if (school_has_feature('osis')): ?>
                <li class="nav-item <?= $active('osis') ?>">
                  <a class="nav-link" href="<?= base_url('sekolah/osis') ?>">
                    OSIS
                  </a>
                </li>
              <?php endif; ?>

              <?php if (school_has_feature('ekstrakurikuler')): ?>
                <li class="nav-item <?= $active('ekstrakurikuler') ?>">
                  <a class="nav-link" href="<?= base_url('sekolah/ekstrakurikuler') ?>">
                    Ekstrakurikuler
                  </a>
                </li>
              <?php endif; ?>

            </ul>
          </div>
        </li>

      <?php endif; ?>
      <!-- ========== KHUSUS SMK ========== -->
      <?php if (school_has_feature('bkk') || school_has_feature('pkl')): ?>
        <li class="nav-category">Khusus SMK</li>
        <?php if (school_has_feature('bkk')): ?>
          <li class="nav-item <?= $active('bkk') ?>" data-title="BKK">
            <a class="nav-link" href="<?= base_url('sekolah/bkk') ?>">
              <i class="typcn typcn-briefcase menu-icon"></i>
              <span class="menu-title">BKK</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if (school_has_feature('pkl')): ?>
          <li class="nav-item <?= $active('pkl') ?>" data-title="PKL">
            <a class="nav-link" href="<?= base_url('sekolah/pkl') ?>">
              <i class="typcn typcn-clipboard menu-icon"></i>
              <span class="menu-title">PKL</span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>

      <!-- ========== CMS WEBSITE ========== -->
      <?php if (school_has_feature('cms_website')): ?>
        <li class="nav-category">Website Sekolah</li>
        <li class="nav-item" data-title="CMS Website">
          <a class="nav-link" data-bs-toggle="collapse" href="#cmsSekolah"
            aria-expanded="<?= $cmsActive ? 'true' : 'false' ?>">
            <i class="typcn typcn-world-outline menu-icon"></i>
            <span class="menu-title">CMS Website</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse <?= $cmsActive ? 'show' : '' ?>" id="cmsSekolah">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?= menu_active('sekolah/home') ?>" data-title="Beranda"><a class="nav-link" href="<?= base_url('sekolah/home') ?>">Beranda</a></li>
              <li class="nav-item <?= menu_active('sekolah/tentang') ?>" data-title="Tentang"><a class="nav-link" href="<?= base_url('sekolah/tentang') ?>">Tentang</a></li>
              <li class="nav-item <?= menu_active('sekolah/jurusan') ?>" data-title="Jurusan"><a class="nav-link" href="<?= base_url('sekolah/jurusan') ?>">Jurusan</a></li>
              <li class="nav-item <?= menu_active('sekolah/visi-misi') ?>" data-title="Visi & Misi"><a class="nav-link" href="<?= base_url('sekolah/visi-misi') ?>">Visi & Misi</a></li>
              <li class="nav-item <?= menu_active('sekolah/fasilitas') ?>" data-title="Fasilitas"><a class="nav-link" href="<?= base_url('sekolah/fasilitas') ?>">Fasilitas</a></li>
              <li class="nav-item <?= menu_active('sekolah/staff') ?>" data-title="Staff"><a class="nav-link" href="<?= base_url('sekolah/staff') ?>">Staff</a></li>
              <li class="nav-item <?= menu_active('sekolah/berita') ?>" data-title="Berita"><a class="nav-link" href="<?= base_url('sekolah/berita') ?>">Berita</a></li>
              <li class="nav-item <?= menu_active('sekolah/galeri') ?>" data-title="Galeri"><a class="nav-link" href="<?= base_url('sekolah/galeri') ?>">Galeri</a></li>
              <li class="nav-item <?= menu_active('sekolah/pengumuman') ?>" data-title="Pengumuman"><a class="nav-link" href="<?= base_url('sekolah/pengumuman') ?>">Pengumuman</a></li>
            </ul>
          </div>
        </li>
      <?php endif; ?>

      <!-- ========== LOGOUT ========== -->
      <li class="nav-item mt-3" data-title="Logout">
        <a class="nav-link" href="<?= base_url('logout') ?>">
          <i class="typcn typcn-power menu-icon text-danger"></i>
          <span class="menu-title text-danger">Logout</span>
        </a>
      </li>

    </ul>
  </div>
</nav>
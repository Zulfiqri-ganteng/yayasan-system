<?php
$type      = $context['type'];
$sekolah   = $context['sekolah'] ?? null;
$jenjang   = $sekolah['jenjang'] ?? null;


?>

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">

        <!-- ================= BRAND ================= -->
        <a class="navbar-brand d-flex align-items-center"
            href="<?= $type === 'sekolah' && $jenjang ? base_url($jenjang) : base_url('/') ?>">

            <img
                src="<?= base_url(
                            'uploads/' . ($type === 'sekolah' ? 'logo/' : 'yayasan/') . $logoNavbar
                        ) ?>"
                alt="Logo"
                class="navbar-logo">

            <div class="brand-text">
                <span class="brand-title">
                    <?= $type === 'sekolah'
                        ? esc($sekolah['nama_sekolah'] ?? lang('App.school'))
                        : esc($profilYayasan['nama_yayasan'] ?? lang('App.foundation')) ?>
                </span>

                <?php if ($type === 'sekolah' && $jenjang): ?>

                    <?php
                    $subtitle = '';

                    if ($jenjang === 'smk') {
                        $subtitle = lang('App.brand_smk_subtitle');
                    } elseif (in_array($jenjang, ['sd', 'smp', 'sma'], true)) {
                        $subtitle = lang('App.brand_city');
                    }

                    ?>

                    <?php if ($subtitle): ?>
                        <small class="brand-subtitle">
                            <?= esc($subtitle) ?>
                        </small>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </a>

        <!-- ================= TOGGLER ================= -->
        <button class="navbar-toggler custom-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- ================= MENU ================= -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if ($type === 'yayasan'): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tentang') ?>">
                            <?= lang('App.tentang') ?>
                        </a>
                    </li>

                    <?php if ($jenjang === 'smk'): ?>

                        <!-- AKADEMIK SMK -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kesiswaan") ?>">
                                        <?= lang('App.kesiswaan') ?>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/program-unggulan") ?>">
                                        <?= lang('App.program_unggulan') ?>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    <?php elseif ($jenjang === 'sma' || $jenjang === 'smp'): ?>

                        <!-- AKADEMIK SMA & SMP -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kesiswaan") ?>">
                                        <?= lang('App.kesiswaan') ?>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    <?php elseif ($jenjang === 'sd' || $jenjang === 'tk'): ?>

                        <!-- AKADEMIK SD & TK -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>

                            </ul>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('berita') ?>">
                            <?= lang('App.berita') ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('galeri') ?>">
                            <?= lang('App.galeri') ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('kontak') ?>">
                            <?= lang('App.kontak') ?>
                        </a>
                    </li>

                <?php elseif ($type === 'sekolah' && $jenjang): ?>

                    <!-- ================= PROFIL ================= -->
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() === "$jenjang/tentang" ? 'active' : '' ?>"
                            href="<?= base_url("$jenjang/tentang") ?>">
                            <?= lang('App.tentang_kami') ?>
                        </a>
                    </li>

                    <?php if ($jenjang === 'smk'): ?>

                        <!-- ================= AKADEMIK (SMK) ================= -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kesiswaan") ?>">
                                        <?= lang('App.kesiswaan') ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/program-unggulan") ?>">
                                        <?= lang('App.program_unggulan') ?>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php elseif ($jenjang === 'sma' || $jenjang === 'smp'): ?>

                        <!-- ================= AKADEMIK (SMA & SMP) ================= -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kesiswaan") ?>">
                                        <?= lang('App.kesiswaan') ?>
                                    </a>
                                </li>

                              

                            </ul>
                        </li>

                    <?php else: ?>

                        <!-- ================= AKADEMIK (TK / SD) ================= -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <?= lang('App.akademik') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-custom">

                                <li>
                                    <a class="dropdown-item" href="<?= base_url("$jenjang/kurikulum") ?>">
                                        <?= lang('App.kurikulum') ?>
                                    </a>
                                </li>

                                <?php if ($jenjang !== 'tk'): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url("$jenjang/ekstrakurikuler") ?>">
                                            <?= lang('App.ekstrakurikuler') ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>

                    <?php endif; ?>
                    <!-- ================= INFORMASI ================= -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <?= lang('App.informasi') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-custom">
                            <li><a class="dropdown-item" href="<?= base_url("$jenjang/berita") ?>"><?= lang('App.berita') ?></a></li>
                            <li><a class="dropdown-item" href="<?= base_url("$jenjang/pengumuman") ?>"><?= lang('App.pengumuman') ?></a></li>
                        </ul>
                    </li>

                    <!-- ================= GALERI ================= -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url("$jenjang/galeri") ?>">
                            <?= lang('App.galeri') ?>
                        </a>
                    </li>

                    <!-- ================= KONTAK ================= -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url("$jenjang/kontak") ?>">
                            <?= lang('App.kontak') ?>
                        </a>
                    </li>

                <?php endif ?>


                <!-- LANGUAGE SWITCHER (PALING KANAN) -->
                <li class="nav-item dropdown ms-lg-3 nav-language">
                    <a class="nav-link lang-toggle"
                        href="#"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-globe me-1"></i>
                        <?= strtoupper(service('request')->getLocale()) ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end lang-dropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('set-language/id') ?>">
                                🇮🇩 Indonesia
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('set-language/en') ?>">
                                🇬🇧 English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('set-language/zh') ?>">
                                🇨🇳 中文
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ACTION BUTTONS -->
                <li class="nav-item nav-actions ms-lg-4">
                    <div class="d-flex gap-2 flex-column flex-lg-row">

                        <?php if ($context['type'] === 'sekolah'): ?>
                            <a href="<?= base_url("$jenjang/ppdb") ?>" class="btn-ppdb d-flex align-items-center gap-2">
                                <i class="fas fa-user-plus"></i>
                                <span><?= lang('App.ppdb') ?></span>
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('login') ?>" class="btn-login d-flex align-items-center gap-2" target="_blank">
                            <i class="fas fa-sign-in-alt"></i>
                            <span><?= lang('App.login') ?></span>
                        </a>

                    </div>
                </li>




            </ul>


        </div>
    </div>
</nav>
<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(false);
$routes->set404Override();

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
$routes->get('login', 'Auth\LoginController::index');
$routes->post('login', 'Auth\LoginController::process');
$routes->get('logout', 'Auth\LoginController::logout');
$routes->get('forgot-password', 'Auth\ForgotPasswordController::index');
$routes->post('forgot-password', 'Auth\ForgotPasswordController::send');

$routes->get('reset-password', 'Auth\ForgotPasswordController::resetForm');
$routes->post('reset-password', 'Auth\ForgotPasswordController::processReset');
$routes->get('test-email', 'TestEmail::index');

$routes->get('/verify-login', 'Auth\LoginController::verifyLogin');
$routes->post('/verify-login', 'Auth\LoginController::processVerifyLogin');
$routes->post('resend-code', 'Auth\LoginController::resendCode');




/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/
$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Admin\DashboardController::index', [
        'filter' => 'role:superadmin'
    ]);
    // ===============================
    // PENGATURAN SUPERADMIN
    // ===============================
    $routes->get('pengaturan', 'Admin\PengaturanController::index', [
        'filter' => 'role:superadmin'
    ]);

    $routes->post('pengaturan/ganti-password', 'Admin\PengaturanController::gantiPassword', [
        'filter' => 'role:superadmin'
    ]);

    // Admin Sekolah
    $routes->get('users', 'Admin\UserController::index', ['filter' => 'role:superadmin']);
    $routes->get('users/create', 'Admin\UserController::create', ['filter' => 'role:superadmin']);
    $routes->post('users/store', 'Admin\UserController::store', ['filter' => 'role:superadmin']);
    $routes->post('users/reset-password/(:num)', 'Admin\UserController::resetPassword/$1');
    $routes->post('users/delete/(:num)', 'Admin\UserController::delete/$1');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');

    // Data Sekolah
    $routes->group('sekolah', ['filter' => 'role:superadmin'], function ($routes) {
        $routes->get('/', 'Admin\SekolahController::index');
        $routes->get('create', 'Admin\SekolahController::create');
        $routes->post('store', 'Admin\SekolahController::store');
        $routes->get('edit/(:num)', 'Admin\SekolahController::edit/$1');
        $routes->post('update/(:num)', 'Admin\SekolahController::update/$1');
        $routes->get('toggle/(:num)', 'Admin\SekolahController::toggle/$1');
    });

    // =============================
    // 🔥 FITUR SEKOLAH (A.4)
    // =============================
    $routes->get('sekolah-fitur/(:num)', 'Admin\FiturSekolahController::index/$1', [
        'filter' => 'role:superadmin'
    ]);

    $routes->post('sekolah-fitur/toggle', 'Admin\FiturSekolahController::toggle', [
        'filter' => 'role:superadmin'
    ]);
    $routes->post('sekolah-fitur/bulk', 'Admin\FiturSekolahController::bulk', [
        'filter' => 'role:superadmin'
    ]);

    // =============================
    // 🔧 MASTER FITUR (GLOBAL)
    // =============================
    $routes->get('fitur', 'Admin\FiturController::index', [
        'filter' => 'role:superadmin'
    ]);

    $routes->get('fitur/create', 'Admin\FiturController::create', [
        'filter' => 'role:superadmin'
    ]);

    $routes->post('fitur/store', 'Admin\FiturController::store', [
        'filter' => 'role:superadmin'
    ]);

    $routes->get('fitur/edit/(:num)', 'Admin\FiturController::edit/$1', [
        'filter' => 'role:superadmin'
    ]);

    $routes->post('fitur/update/(:num)', 'Admin\FiturController::update/$1', [
        'filter' => 'role:superadmin'
    ]);

    $routes->post('fitur/delete/(:num)', 'Admin\FiturController::delete/$1', [
        'filter' => 'role:superadmin'
    ]);
});


/*
|--------------------------------------------------------------------------
| CMS WEBSITE YAYASAN (SUPERADMIN)
|--------------------------------------------------------------------------
*/
$routes->group('admin/yayasan', [
    'filter' => ['auth', 'role:superadmin']
], function ($routes) {


    // Profil Yayasan
    $routes->get('profil', 'Admin\Yayasan\ProfilController::index');
    $routes->post('profil/save', 'Admin\Yayasan\ProfilController::save');

    // Tentang Yayasan
    $routes->get('tentang', 'Admin\Yayasan\TentangController::index');
    $routes->post('tentang/save', 'Admin\Yayasan\TentangController::save');

    // Sejarah
    $routes->get('sejarah', 'Admin\Yayasan\SejarahController::index');
    $routes->post('sejarah/save', 'Admin\Yayasan\SejarahController::save');
    $routes->get('sejarah/delete/(:num)', 'Admin\Yayasan\SejarahController::delete/$1');

    // CMS BERANDA
    $routes->get('home', 'Admin\Yayasan\HomeController::index');
    $routes->post('home/save', 'Admin\Yayasan\HomeController::save');

    // VISI & MISI  ✅ FIX
    $routes->get('visi-misi', 'Admin\Yayasan\VisiMisiController::index');
    $routes->post('visi-misi/save', 'Admin\Yayasan\VisiMisiController::save');
    // GALERI YAYASAN
    $routes->get('galeri', 'Admin\Yayasan\GaleriYayasan::index');
    $routes->get('galeri/create', 'Admin\Yayasan\GaleriYayasan::create');
    $routes->post('galeri/store', 'Admin\Yayasan\GaleriYayasan::store');
    $routes->get('galeri/edit/(:num)', 'Admin\Yayasan\GaleriYayasan::edit/$1');
    $routes->post('galeri/update/(:num)', 'Admin\Yayasan\GaleriYayasan::update/$1');
    $routes->get('galeri/delete/(:num)', 'Admin\Yayasan\GaleriYayasan::delete/$1');
    // BERITA YAYASAN
    $routes->get('berita', 'Admin\Yayasan\BeritaController::index');
    $routes->get('berita/create', 'Admin\Yayasan\BeritaController::create');
    $routes->post('berita/store', 'Admin\Yayasan\BeritaController::store');
    $routes->get('berita/edit/(:num)', 'Admin\Yayasan\BeritaController::edit/$1');
    $routes->post('berita/update/(:num)', 'Admin\Yayasan\BeritaController::update/$1');

    $routes->get('berita/delete/(:num)', 'Admin\Yayasan\BeritaController::delete/$1');
    $routes->get('berita/toggle/(:num)', 'Admin\Yayasan\BeritaController::toggleStatus/$1');

    // staff yayasan
    // STAFF YAYASAN
    $routes->get('staff', 'Admin\Yayasan\StaffController::index');
    $routes->get('staff/create', 'Admin\Yayasan\StaffController::create');
    $routes->post('staff/store', 'Admin\Yayasan\StaffController::store');
    $routes->get('staff/delete/(:num)', 'Admin\Yayasan\StaffController::delete/$1');
    $routes->get('staff/edit/(:num)', 'Admin\Yayasan\StaffController::edit/$1');
    $routes->post('staff/update/(:num)', 'Admin\Yayasan\StaffController::update/$1');

    $routes->get('akademik', 'Admin\Yayasan\AkademikController::index');
    $routes->get('akademik/create', 'Admin\Yayasan\AkademikController::create');
    $routes->post('akademik/store', 'Admin\Yayasan\AkademikController::store');

    $routes->get('akademik/edit/(:num)', 'Admin\Yayasan\AkademikController::edit/$1');
    $routes->post('akademik/update/(:num)', 'Admin\Yayasan\AkademikController::update/$1');

    $routes->post('akademik/delete/(:num)', 'Admin\Yayasan\AkademikController::delete/$1');
});
$routes->group('admin/yayasan/system', [
    'filter' => ['auth', 'role:superadmin']
], function ($routes) {
    $routes->get('orphan-files', 'Yayasan\System\OrphanFileController::index');
    $routes->get('orphan-files/preview', 'Yayasan\System\OrphanFileController::preview');
    $routes->post('orphan-files/delete', 'Yayasan\System\OrphanFileController::delete');

    $routes->get('backup', 'Yayasan\System\BackupController::index');
    $routes->post('backup/run-ajax', 'Yayasan\System\BackupController::runAjax');
    $routes->get('backup/download/(:segment)', 'Yayasan\System\BackupController::download/$1');
    $routes->post('backup/restore', 'Yayasan\System\BackupController::restore');
    $routes->post('backup/delete', 'Yayasan\System\BackupController::delete');
});




/*
|--------------------------------------------------------------------------
| ADMIN SEKOLAH
|--------------------------------------------------------------------------
*/
$routes->group('sekolah', [
    'filter' => ['auth', 'role:admin_sekolah']
], function ($routes) {
    // ekskullll
    $routes->get('ekstrakurikuler', 'Sekolah\EkstrakurikulerController::index', [
        'filter' => 'feature:ekstrakurikuler'
    ]);
    $routes->get('ekstrakurikuler/create', 'Sekolah\EkstrakurikulerController::create', [
        'filter' => 'feature:ekstrakurikuler'
    ]);

    $routes->post('ekstrakurikuler/store', 'Sekolah\EkstrakurikulerController::store', [
        'filter' => 'feature:ekstrakurikuler'
    ]);

    $routes->get('ekstrakurikuler/edit/(:num)', 'Sekolah\EkstrakurikulerController::edit/$1', [
        'filter' => 'feature:ekstrakurikuler'
    ]);

    $routes->post('ekstrakurikuler/update/(:num)', 'Sekolah\EkstrakurikulerController::update/$1', [
        'filter' => 'feature:ekstrakurikuler'
    ]);

    $routes->get('ekstrakurikuler/delete/(:num)', 'Sekolah\EkstrakurikulerController::delete/$1', [
        'filter' => 'feature:ekstrakurikuler'
    ]);
    // ===============================
    // PPDB PENDAFTAR - PRINT & PDF
    // ===============================

    $routes->get('ppdb/pendaftar/print', 'Sekolah\PpdbController::printPendaftar', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/pendaftar/pdf', 'Sekolah\PpdbController::exportPdf', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/pendaftar', 'Sekolah\PpdbController::pendaftar', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/pendaftar/status/(:num)/(:segment)', 'Sekolah\PpdbController::updateStatus/$1/$2', [
        'filter' => 'feature:ppdb'
    ]);


    $routes->get('dashboard', 'Sekolah\DashboardController::index', [
        'filter' => 'feature:dashboard'
    ]);

    $routes->get('profil', 'Sekolah\ProfilSekolahController::index', [
        'filter' => 'feature:profil_sekolah'
    ]);

    $routes->post('profil/simpan', 'Sekolah\ProfilSekolahController::simpan', [
        'filter' => 'feature:profil_sekolah'
    ]);
    // =============================
    // 🔐 GANTI PASSWORD ADMIN SEKOLAH
    // =============================
    $routes->post('profil/ganti-password', 'Sekolah\ProfilSekolahController::gantiPassword', [
        'filter' => 'feature:profil_sekolah'
    ]);

    // pengumuman sekolah admin
    // ================= CMS BERANDA SEKOLAH =================
    $routes->get('home', 'Sekolah\HomeController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('home/simpan', 'Sekolah\HomeController::simpan', [
        'filter' => 'feature:cms_website'
    ]);
    /* ================= CMS PENGUMUMAN ================= */

    $routes->get('pengumuman', 'Sekolah\PengumumanController::index', [
        'filter' => 'feature:pengumuman'
    ]);

    $routes->get('pengumuman/create', 'Sekolah\PengumumanController::create', [
        'filter' => 'feature:pengumuman'
    ]);

    $routes->post('pengumuman/store', 'Sekolah\PengumumanController::store', [
        'filter' => 'feature:pengumuman'
    ]);

    $routes->get('pengumuman/edit/(:num)', 'Sekolah\PengumumanController::edit/$1', [
        'filter' => 'feature:pengumuman'
    ]);

    $routes->post('pengumuman/update/(:num)', 'Sekolah\PengumumanController::update/$1', [
        'filter' => 'feature:pengumuman'
    ]);

    $routes->get('pengumuman/delete/(:num)', 'Sekolah\PengumumanController::delete/$1', [
        'filter' => 'feature:pengumuman'
    ]);

    // ppdb
    $routes->get('ppdb', 'Sekolah\PpdbController::index', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/create', 'Sekolah\PpdbController::create', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->post('ppdb/store', 'Sekolah\PpdbController::store', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/edit/(:num)', 'Sekolah\PpdbController::edit/$1', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->post('ppdb/update/(:num)', 'Sekolah\PpdbController::update/$1', [
        'filter' => 'feature:ppdb'
    ]);

    $routes->get('ppdb/delete/(:num)', 'Sekolah\PpdbController::delete/$1', [
        'filter' => 'feature:ppdb'
    ]);
    // ===============================
    // CMS STAFF SEKOLAH
    // ===============================
    $routes->get('staff', 'Sekolah\StaffController::index', [
        'filter' => 'feature:staff'
    ]);

    $routes->get('staff/create', 'Sekolah\StaffController::create', [
        'filter' => 'feature:staff'
    ]);

    $routes->post('staff/store', 'Sekolah\StaffController::store', [
        'filter' => 'feature:staff'
    ]);

    $routes->get('staff/edit/(:num)', 'Sekolah\StaffController::edit/$1', [
        'filter' => 'feature:staff'
    ]);

    $routes->post('staff/update/(:num)', 'Sekolah\StaffController::update/$1', [
        'filter' => 'feature:staff'
    ]);

    $routes->get('staff/delete/(:num)', 'Sekolah\StaffController::delete/$1', [
        'filter' => 'feature:staff'
    ]);
    // ===============================
    // CMS FASILITAS SEKOLAH
    // ===============================
    $routes->get('fasilitas', 'Sekolah\FasilitasController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('fasilitas/create', 'Sekolah\FasilitasController::create', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('fasilitas/store', 'Sekolah\FasilitasController::store', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('fasilitas/edit/(:num)', 'Sekolah\FasilitasController::edit/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('fasilitas/update/(:num)', 'Sekolah\FasilitasController::update/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('fasilitas/delete/(:num)', 'Sekolah\FasilitasController::delete/$1', [
        'filter' => 'feature:cms_website'
    ]);

    /* ================= MASTER DATA ================= */

    $routes->get('kelas', 'Sekolah\ComingSoonController::index/Kelas & Rombel', [
        'filter' => 'feature:kelas'
    ]);

    $routes->get('mapel', 'Sekolah\ComingSoonController::index/Mata Pelajaran', [
        'filter' => 'feature:mapel'
    ]);

    $routes->get('master-jurusan', 'Sekolah\ComingSoonController::index/Jurusan', [
        'filter' => 'feature:jurusan'
    ]);

    /* ================= AKADEMIK ================= */

    $routes->get('tahun-ajaran', 'Sekolah\ComingSoonController::index/Tahun Ajaran', [
        'filter' => 'feature:tahun_ajaran'
    ]);

    $routes->get('nilai', 'Sekolah\ComingSoonController::index/Nilai', [
        'filter' => 'feature:nilai_rapor'
    ]);

    $routes->get('rapor', 'Sekolah\ComingSoonController::index/Rapor', [
        'filter' => 'feature:nilai_rapor'
    ]);

    /* ================= JADWAL ================= */

    $routes->get('jadwal-pelajaran', 'Sekolah\ComingSoonController::index/Jadwal Pelajaran', [
        'filter' => 'feature:jadwal_pelajaran'
    ]);

    $routes->get('jadwal-guru', 'Sekolah\ComingSoonController::index/Jadwal Guru', [
        'filter' => 'feature:jadwal_pelajaran'
    ]);

    $routes->get('jadwal-ekskul', 'Sekolah\ComingSoonController::index/Jadwal Ekskul', [
        'filter' => 'feature:jadwal_pelajaran'
    ]);

    /* ================= ABSENSI ================= */

    $routes->get('absensi-siswa', 'Sekolah\ComingSoonController::index/Absensi Siswa', [
        'filter' => 'feature:absensi'
    ]);

    $routes->get('absensi-guru', 'Sekolah\ComingSoonController::index/Absensi Guru', [
        'filter' => 'feature:absensi'
    ]);

    $routes->get('qr-generator', 'Sekolah\ComingSoonController::index/QR Generator', [
        'filter' => 'feature:absensi'
    ]);

    $routes->get('scan-qr', 'Sekolah\ComingSoonController::index/Scan QR', [
        'filter' => 'feature:absensi'
    ]);

    $routes->get('laporan-absensi', 'Sekolah\ComingSoonController::index/Laporan Absensi', [
        'filter' => 'feature:absensi'
    ]);

    /* ================= KEUANGAN ================= */

    $routes->get('tabungan', 'Sekolah\ComingSoonController::index/Tabungan', [
        'filter' => 'feature:tabungan'
    ]);

    $routes->get('pembayaran', 'Sekolah\ComingSoonController::index/Pembayaran', [
        'filter' => 'feature:pembayaran'
    ]);

    $routes->get('laporan-keuangan', 'Sekolah\ComingSoonController::index/Laporan Keuangan', [
        'filter' => 'feature:pembayaran'
    ]);

    /* ================= CMS WEBSITE ================= */
    // tentang sekolah
    $routes->get('tentang', 'Sekolah\TentangController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('tentang/save', 'Sekolah\TentangController::save', [
        'filter' => 'feature:cms_website'
    ]);
    // visi misi
    $routes->get('visi-misi', 'Sekolah\VisiMisiController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('visi-misi/save', 'Sekolah\VisiMisiController::save', [
        'filter' => 'feature:cms_website'
    ]);

    // berita sekolah
    $routes->get('berita', 'Sekolah\BeritaController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('berita/create', 'Sekolah\BeritaController::create', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('berita/store', 'Sekolah\BeritaController::store', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('berita/edit/(:num)', 'Sekolah\BeritaController::edit/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('berita/update/(:num)', 'Sekolah\BeritaController::update/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('berita/delete/(:num)', 'Sekolah\BeritaController::delete/$1', [
        'filter' => 'feature:cms_website'
    ]);
    // galeri sekolah
    /* ================= CMS GALERI SEKOLAH ================= */

    $routes->get('galeri', 'Sekolah\GaleriController::index', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('galeri/create', 'Sekolah\GaleriController::create', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('galeri/store', 'Sekolah\GaleriController::store', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('galeri/edit/(:num)', 'Sekolah\GaleriController::edit/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->post('galeri/update/(:num)', 'Sekolah\GaleriController::update/$1', [
        'filter' => 'feature:cms_website'
    ]);

    $routes->get('galeri/delete/(:num)', 'Sekolah\GaleriController::delete/$1', [
        'filter' => 'feature:cms_website'
    ]);
    /* ================= CMS JURUSAN WEBSITE ================= */
    $routes->group('jurusan', [
        'namespace' => 'App\Controllers\Sekolah',
        'filter'    => 'feature:cms_jurusan'
    ], function ($routes) {

        $routes->get('/', 'JurusanController::index');
        $routes->get('create', 'JurusanController::create');
        $routes->post('store', 'JurusanController::store');

        $routes->get('edit/(:num)', 'JurusanController::edit/$1');
        $routes->post('update/(:num)', 'JurusanController::update/$1');

        // 🔒 DELETE HARUS POST
        $routes->post('delete/(:num)', 'JurusanController::delete/$1');
    });



    /* ================= KHUSUS SMK ================= */

    $routes->get('bkk', 'Sekolah\ComingSoonController::index/BKK', [
        'filter' => 'feature:bkk'
    ]);

    $routes->get('pkl', 'Sekolah\ComingSoonController::index/PKL', [
        'filter' => 'feature:pkl'
    ]);
});

// routes untuk bahasa
$routes->get('set-language/(:segment)', 'Frontend\LanguageController::switch/$1');

/*|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| FRONTEND YAYASAN (ROOT DOMAIN)
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Frontend\HomeController::index');

$routes->get('tentang', 'Frontend\TentangController::index');

$routes->get('berita', 'Frontend\BeritaController::index');
$routes->get('berita/(:segment)', 'Frontend\BeritaController::detail/$1');

$routes->get('pengumuman', 'Frontend\PengumumanController::index');
$routes->get('pengumuman/(:num)', 'Frontend\PengumumanController::detail/$1');

$routes->get('galeri', 'Frontend\GaleriController::index');
$routes->get('kontak', 'Frontend\KontakController::index');

$routes->get('akademik', 'Frontend\AkademikController::index');
$routes->get('akademik/(:segment)', 'Frontend\AkademikController::detail/$1');
/*
|--------------------------------------------------------------------------
| FRONTEND SEKOLAH
|--------------------------------------------------------------------------
*/
// $routes->group('(:segment)', function ($routes) {

//     $routes->get('/', 'Frontend\HomeController::index');

//     $routes->get('tentang', 'Frontend\TentangController::index');

//     $routes->get('berita', 'Frontend\BeritaController::index');
//     $routes->get('berita/(:segment)', 'Frontend\BeritaController::detail/$2');

//     $routes->get('pengumuman', 'Frontend\PengumumanController::index');
//     $routes->get('pengumuman/(:num)', 'Frontend\PengumumanController::detail/$2');

//     $routes->get('galeri', 'Frontend\GaleriController::index');
//     $routes->get('kontak', 'Frontend\KontakController::index');

//     $routes->get('kurikulum', 'Frontend\ComingSoonController::kurikulum');
//     $routes->get('kesiswaan/osis', 'Frontend\ComingSoonController::osis');
//     $routes->get('kesiswaan/prestasi', 'Frontend\ComingSoonController::prestasi');
//     // $routes->get('ekstrakurikuler', 'Frontend\EkskulController::index');

//     // khusus SMK
//     /*
//     ================= PROGRAM UNGGULAN =================
//     */

//     $routes->get('program-unggulan', 'Frontend\ProgramUnggulanController::index');

//     $routes->get('program-unggulan/jurusan', 'Frontend\JurusanController::index');
//     $routes->get('program-unggulan/jurusan/(:segment)', 'Frontend\JurusanController::detail/$2');

//     $routes->get('program-unggulan/pkl', 'Frontend\ComingSoonController::pkl');
//     $routes->get('program-unggulan/bkk', 'Frontend\ComingSoonController::bkk');

//     // SD / TK
//     $routes->get('kegiatan', 'Frontend\KegiatanController::index');

//     $routes->get('ppdb', 'Frontend\PpdbController::index'); // ✅ WAJIB
//     $routes->get('ppdb/daftar', 'Frontend\PpdbController::form');
//     $routes->post('ppdb/daftar', 'Frontend\PpdbController::submit');


//     // SMA
//     $routes->get('projek-p5', 'Frontend\ComingSoonController::projekP5');
//     $routes->get('jadwal-pelajaran', 'Frontend\ComingSoonController::jadwalPelajaran');

//     // ================= KESISWAAN =================
//     $routes->get('kesiswaan', 'Frontend\KesiswaanController::index');

//     $routes->get('kesiswaan/ekstrakurikuler', 'Frontend\EkstrakurikulerController::index');
//     $routes->get('kesiswaan/ekstrakurikuler/(:segment)', 'Frontend\EkstrakurikulerController::detail/$2');

//     $routes->get('kesiswaan/osis', 'Frontend\ComingSoonController::osis');
// });

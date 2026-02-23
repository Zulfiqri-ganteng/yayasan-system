<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\ProfilSekolahModel;
use App\Models\Yayasan\ProfilYayasanModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class FrontendBaseController extends BaseController
{
    /**
     * ==================================================
     * GLOBAL CONTEXT
     * ==================================================
     */
    protected $context = [
        'type'       => 'yayasan', // yayasan | sekolah
        'sekolah_id' => 0,
        'sekolah'    => null,
        'jenjang'    => null,
    ];

    protected $profilYayasan;
    protected $profilSekolah = null;
    protected $logoNavbar;
    protected $favicon;

    /**
     * ==================================================
     * INIT CONTROLLER
     * ==================================================
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        // ===========================
        // SET LANGUAGE GLOBAL
        // ===========================
        $language = session()->get('site_lang') ?? config('App')->defaultLocale;
        service('request')->setLocale($language);

        // Ambil segment pertama untuk deteksi
        $segment = strtolower((string) $request->getUri()->getSegment(1));

        /**
         * 0️⃣ BYPASS UNTUK SISTEM (LOGIN/ADMIN)
         * Agar tidak diinterupsi oleh logika frontend
         */
        $systemRoutes = ['admin', 'login', 'logout', 'forgot-password', 'reset-password', 'verify-login', 'resend-code'];
        if (in_array($segment, $systemRoutes)) {
            return;
        }

        /**
         * 1️⃣ LOAD PROFIL YAYASAN (DEFAULT)
         */
        $profilYayasanModel  = new ProfilYayasanModel();
        $this->profilYayasan = $profilYayasanModel->first();

        $this->context = [
            'type'       => 'yayasan',
            'sekolah_id' => 0,
            'sekolah'    => null,
            'jenjang'    => null,
        ];

        $this->logoNavbar = $this->profilYayasan['logo'] ?? 'logo.png';
        $this->favicon = !empty($this->profilYayasan['logo'])
            ? 'uploads/yayasan/' . $this->profilYayasan['logo']
            : 'theme/img/default.png';

        /**
         * 2️⃣ DETEKSI MODE (SUBDOMAIN / PATH)
         */
        $host = strtolower((string) $request->getServer('HTTP_HOST'));
        $jenjang = null;

        // Daftar jenjang resmi
        $listJenjang = ['smk', 'sma', 'smp', 'sd', 'tk'];

        // SUBDOMAIN MODE (smk.domain.com)
        if (preg_match('/^(smk|sma|smp|sd|tk)\./', $host, $match)) {
            $jenjang = $match[1];
        }

        // PATH MODE (localhost/smk)
        if (!$jenjang && in_array($segment, $listJenjang)) {
            $jenjang = $segment;
        }

        /**
         * 🔒 VALIDASI SEGMENT (FIXED 404 ISSUE)
         * Logika: Jika segment ada, tapi bukan jenjang sekolah, 
         * cek apakah itu route milik yayasan. Jika bukan keduanya, baru 404.
         */
        $yayasanRoutes = ['tentang', 'berita', 'pengumuman', 'galeri', 'kontak', 'akademik'];

        if ($segment && !$jenjang) {
            if (!in_array($segment, $yayasanRoutes)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }

        /**
         * 3️⃣ JIKA SEKOLAH TERDETEKSI
         */
        if ($jenjang) {
            $sekolahModel = new SekolahModel();
            $sekolah = $sekolahModel
                ->where('jenjang', $jenjang)
                ->where('status', 1)
                ->first();

            if ($sekolah) {
                $this->context = [
                    'type'       => 'sekolah',
                    'sekolah_id' => (int) $sekolah['id'],
                    'sekolah'    => $sekolah,
                    'jenjang'    => $jenjang,
                ];

                // LOAD PROFIL SEKOLAH
                $profilSekolahModel = new ProfilSekolahModel();
                $this->profilSekolah = $profilSekolahModel
                    ->where('sekolah_id', $sekolah['id'])
                    ->orderBy('updated_at', 'DESC')
                    ->first();

                if (!empty($this->profilSekolah['logo'])) {
                    $this->logoNavbar = $this->profilSekolah['logo'];
                    $this->favicon = 'uploads/logo/' . $this->profilSekolah['logo'];
                }
            } else {
                // Jika segment adalah jenjang (misal /smp) tapi tidak ada di DB
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
        /**
         * =========================
         * GLOBAL INSTITUTION NAME
         * =========================
         */
        $institutionName = $this->context['type'] === 'sekolah'
            ? ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah')
            : ($this->profilYayasan['nama_yayasan'] ?? 'Yayasan');

        /**
         * 4️⃣ SHARE GLOBAL DATA KE SEMUA VIEW
         */

        service('renderer')->setData([
            'context'        => $this->context,
            'profilYayasan'  => $this->profilYayasan,
            'profilSekolah'  => $this->profilSekolah,
            'logoNavbar'     => $this->logoNavbar,
            'favicon' => $this->favicon,
            'ctxUrl'         => fn($path = '') => $this->ctxUrl($path),
            'institutionName' => $institutionName,
        ]);
    }

    /**
     * ==================================================
     * CONTEXT-AWARE URL HELPER
     * ==================================================
     */
    protected function ctxUrl(string $path = ''): string
    {
        $path = ltrim($path, '/');

        if ($this->context['type'] === 'sekolah' && $this->context['jenjang']) {
            return base_url($this->context['jenjang'] . '/' . $path);
        }

        return base_url($path);
    }
}

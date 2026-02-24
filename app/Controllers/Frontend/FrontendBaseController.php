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

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // =====================================
        // 1️⃣ SET LANGUAGE
        // =====================================
        $language = session()->get('site_lang') ?? config('App')->defaultLocale;
        service('request')->setLocale($language);

        $segment = strtolower((string) $request->getUri()->getSegment(1));

        // =====================================
        // 2️⃣ BYPASS ROUTE SISTEM
        // =====================================
        $systemRoutes = [
            'admin',
            'login',
            'logout',
            'forgot-password',
            'reset-password',
            'verify-login',
            'resend-code'
        ];

        if (in_array($segment, $systemRoutes)) {
            return;
        }

        // =====================================
        // 3️⃣ LOAD PROFIL YAYASAN (DEFAULT)
        // =====================================
        $profilYayasanModel = new ProfilYayasanModel();
        $this->profilYayasan = $profilYayasanModel->first();

        $this->logoNavbar = $this->profilYayasan['logo'] ?? 'logo.png';
        $this->favicon = !empty($this->profilYayasan['logo'])
            ? 'uploads/yayasan/' . $this->profilYayasan['logo']
            : 'theme/img/default.png';

        // =====================================
        // 4️⃣ DETEKSI SUBDOMAIN SEKOLAH
        // =====================================
        $host = strtolower((string) $request->getServer('HTTP_HOST'));
        $jenjang = null;

        if (preg_match('/^(smk|sma|smp|sd|tk)\./', $host, $match)) {
            $jenjang = $match[1];
        }

        // =====================================
        // 5️⃣ JIKA SEKOLAH TERDETEKSI
        // =====================================
        if ($jenjang) {

            $sekolahModel = new SekolahModel();
            $sekolah = $sekolahModel
                ->where('jenjang', $jenjang)
                ->where('status', 1)
                ->first();

            if (!$sekolah) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $this->context = [
                'type'       => 'sekolah',
                'sekolah_id' => (int) $sekolah['id'],
                'sekolah'    => $sekolah,
                'jenjang'    => $jenjang,
            ];

            $profilSekolahModel = new ProfilSekolahModel();
            $this->profilSekolah = $profilSekolahModel
                ->where('sekolah_id', $sekolah['id'])
                ->orderBy('updated_at', 'DESC')
                ->first();

            if (!empty($this->profilSekolah['logo'])) {
                $this->logoNavbar = $this->profilSekolah['logo'];
                $this->favicon = 'uploads/logo/' . $this->profilSekolah['logo'];
            }
        }

        // =====================================
        // 6️⃣ SHARE GLOBAL DATA KE VIEW
        // =====================================
        $institutionName = $this->context['type'] === 'sekolah'
            ? ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah')
            : ($this->profilYayasan['nama_yayasan'] ?? 'Yayasan');

        service('renderer')->setData([
            'context'         => $this->context,
            'profilYayasan'   => $this->profilYayasan,
            'profilSekolah'   => $this->profilSekolah,
            'logoNavbar'      => $this->logoNavbar,
            'favicon'         => $this->favicon,
            'institutionName' => $institutionName,
            'ctxUrl'          => fn($path = '') => $this->ctxUrl($path),
        ]);
    }

    // =====================================
    // CONTEXT AWARE URL
    // =====================================
    protected function ctxUrl(string $path = ''): string
    {
        return base_url(ltrim($path, '/'));
    }
}

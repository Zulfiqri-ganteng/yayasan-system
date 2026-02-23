<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// Models
use App\Models\ProfilSekolahModel;
use App\Models\Yayasan\ProfilYayasanModel;
use App\Models\CmsAkademikModel;

class BaseController extends Controller
{
    protected $request;

    protected $helpers = ['url'];

    // ===== GLOBAL DATA =====
    protected $profilSekolah = null;
    protected $profilYayasan = null;
    protected $akademik      = [];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        if (session()->get('site_lang')) {
            service('request')->setLocale(session()->get('site_lang'));
        }
        /**
         * ===============================
         * PROFIL YAYASAN (GLOBAL)
         * ===============================
         */
        $profilYayasanModel   = new ProfilYayasanModel();
        $this->profilYayasan  = $profilYayasanModel->first();

        /**
         * ===============================
         * PROFIL SEKOLAH (ADMIN SEKOLAH)
         * ===============================
         */
        if (
            session()->get('role') === 'admin_sekolah' &&
            session()->get('sekolah_id')
        ) {
            $profilSekolahModel = new ProfilSekolahModel();
            $this->profilSekolah = $profilSekolahModel
                ->where('sekolah_id', session()->get('sekolah_id'))
                ->first();
        }

        /**
         * ===============================
         * AKADEMIK (GLOBAL – NAVBAR)
         * ===============================
         */
        $akademikModel = new CmsAkademikModel();
        $this->akademik = $akademikModel
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        /**
         * ===============================
         * SHARE KE SEMUA VIEW
         * ===============================
         */
        service('renderer')->setData([
            'profilYayasan' => $this->profilYayasan,
            'profilSekolah' => $this->profilSekolah,
            'akademik'      => $this->akademik,
        ]);
    }

    // setting frontend dinamis all website
    protected function detectFrontendContext(): array
    {
        $host = service('request')->getServer('HTTP_HOST');
        $host = explode(':', $host)[0];

        // DOMAIN YAYASAN
        if ($host === 'galajuara.sch.id' || $host === 'www.galajuara.sch.id') {
            return [
                'type'       => 'yayasan',
                'sekolah_id' => 0,
                'sekolah'    => null,
            ];
        }

        // SUBDOMAIN SEKOLAH
        $subdomain = explode('.', $host)[0];

        $sekolah = model('SekolahModel')
            ->where('subdomain', $subdomain)
            ->where('status', 1)
            ->first();

        if (!$sekolah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Sekolah tidak ditemukan'
            );
        }

        return [
            'type'       => 'sekolah',
            'sekolah_id' => (int) $sekolah['id'],
            'sekolah'    => $sekolah,
        ];
    }
}

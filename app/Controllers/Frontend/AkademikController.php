<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use App\Models\CmsAkademikModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AkademikController extends FrontendBaseController
{
    protected $akademikModel;

    public function __construct()
    {
        $this->akademikModel = new CmsAkademikModel();
    }

    /**
     * =========================
     * LIST AKADEMIK (YAYASAN)
     * =========================
     */
    public function index()
    {
        // 🔒 BLOK SEKOLAH
        if ($this->context['type'] !== 'yayasan') {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('frontend/akademik/index', [
            'title'    => 'Unit Pendidikan | ' . ($this->profilYayasan['nama_yayasan'] ?? 'Yayasan'),
            'type'     => 'yayasan',
            'context'  => $this->context,

            'akademik' => $this->akademikModel
                ->where('status', 'aktif')
                ->orderBy('urutan', 'ASC')
                ->findAll(),
        ]);
    }

    /**
     * =========================
     * DETAIL AKADEMIK (YAYASAN)
     * =========================
     */
    public function detail($jenjang)
    {
        // 🔒 BLOK SEKOLAH
        if ($this->context['type'] !== 'yayasan') {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->akademikModel
            ->where('jenjang', strtolower($jenjang))
            ->where('status', 'aktif')
            ->first();

        if (!$data) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('frontend/akademik/detail', [
            'title'   => 'Akademik ' . strtoupper($jenjang),
            'type'    => 'yayasan',
            'context' => $this->context,
            'data'    => $data,
        ]);
    }
}

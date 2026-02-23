<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

// YAYASAN
use App\Models\Yayasan\TentangYayasanModel;
use App\Models\Yayasan\SejarahYayasanModel;

// SEKOLAH
use App\Models\Sekolah\TentangSekolahModel;

// UMUM
use App\Models\CmsVisiMisiModel;
use App\Models\CmsStaffModel;
use App\Models\CmsAkademikModel;

class TentangController extends FrontendBaseController
{
    public function index()
    {
        $type      = $this->context['type'];        // yayasan | sekolah
        $sekolahId = (int) $this->context['sekolah_id'];

        /**
         * =========================
         * HARD GUARD
         * =========================
         */
        if ($type === 'sekolah' && $sekolahId <= 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        /**
         * =========================
         * NORMALISASI DEFAULT
         * =========================
         */
        $tentang   = null;
        $sejarah   = [];
        $visiMisi  = null;
        $staff     = [];
        $akademik  = [];

        $visiMisiModel = new CmsVisiMisiModel();
        $staffModel    = new CmsStaffModel();

        /**
         * =========================
         * TENTANG SEKOLAH
         * =========================
         */
        if ($type === 'sekolah') {

            // Tentang sekolah
            $tentang = (new TentangSekolahModel())
                ->where('sekolah_id', $sekolahId)
                ->first();

            // Visi Misi sekolah
            $visiMisi = $visiMisiModel
                ->where('sekolah_id', $sekolahId)
                ->first();

            // Staff sekolah
            $staff = $staffModel->staffSekolah($sekolahId);

            // ❌ sekolah TIDAK punya sejarah yayasan
            $sejarah  = [];
            $akademik = [];
        }

        /**
         * =========================
         * TENTANG YAYASAN
         * =========================
         */
        else {

            // Tentang yayasan (ambil TERAKHIR)
            $tentang = (new TentangYayasanModel())
                ->orderBy('id', 'DESC')
                ->first();

            // Sejarah yayasan
            $sejarah = (new SejarahYayasanModel())
                ->where('status', 1)
                ->orderBy('urutan', 'ASC')
                ->findAll();

            // Visi Misi yayasan
            $visiMisi = $visiMisiModel
                ->where('sekolah_id', 0)
                ->first();

            // Staff yayasan
            $staff = $staffModel->staffYayasan();

            // Akademik hanya untuk yayasan
            $akademik = (new CmsAkademikModel())
                ->where('status', 'aktif')
                ->orderBy('urutan', 'ASC')
                ->findAll();
        }

        /**
         * =========================
         * VIEW
         * =========================
         */
        return view('frontend/tentang/index', [
            'title' => $type === 'sekolah'
                ? 'Tentang ' . ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah')
                : 'Tentang Yayasan',

            'context' => $this->context,

            'tentang'  => $tentang,
            'sejarah'  => $sejarah,
            'visiMisi' => $visiMisi,
            'staff'    => $staff,
            'akademik' => $akademik,
        ]);
    }
}

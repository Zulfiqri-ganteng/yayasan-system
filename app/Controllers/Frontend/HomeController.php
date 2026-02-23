<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;

// HOME
use App\Models\CmsHomeModel;
use App\Models\Sekolah\HomeSekolahModel;
use App\Models\CmsJurusanModel;

// SEKOLAH
use App\Models\Sekolah\TentangSekolahModel;
use App\Models\CmsFasilitasModel;
use App\Models\CmsEkskulModel;
use App\Models\CmsStaffModel;

// UMUM
use App\Models\CmsVisiMisiModel;
use App\Models\Sekolah\VisiMisiSekolahModel;

use App\Models\CmsBeritaModel;

// YAYASAN
use App\Models\Yayasan\TentangYayasanModel;

class HomeController extends FrontendBaseController
{
    public function index()
    {
        $type      = $this->context['type'];        // yayasan | sekolah
        $sekolahId = (int) $this->context['sekolah_id'];

        /**
         * ==================================================
         * HARD GUARD (ANTI BOCOR)
         * ==================================================
         */
        if ($type === 'sekolah' && $sekolahId <= 0) {
            // Sekolah tapi ID tidak valid → STOP
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        /**
         * ==================================================
         * NORMALISASI DEFAULT (WAJIB)
         * ==================================================
         */
        $home = [
            'hero_title'    => null,
            'hero_subtitle' => null,
            'hero_images'   => [],

        ];

        $tentang        = null;
        $visiMisi       = null;
        $fasilitas      = [];
        $ekskul         = [];
        $beritaTerbaru  = [];
        $staff         = [];
        $jurusanHome       = [];

        /**
         * ==================================================
         * HOME SEKOLAH
         * ==================================================
         */
        if ($type === 'sekolah') {
            // ---------- STAFF SEKOLAH ----------
            $staff = (new CmsStaffModel())
                ->where('level', 'sekolah')
                ->where('sekolah_id', $sekolahId)
                ->where('status', 'aktif')
                ->orderBy('urutan', 'ASC')
                ->findAll();
            // ---------- JURUSAN SEKOLAH (KHUSUS SMK) ----------
            if (
                isset($this->context['sekolah']['jenjang']) &&
                strtolower($this->context['sekolah']['jenjang']) === 'smk'
            ) {
                $jurusanHome = (new CmsJurusanModel())
                    ->where('sekolah_id', $sekolahId)
                    ->where('status', 'publish')
                    ->orderBy('urutan', 'ASC')
                    ->findAll(3);
            }


            // ---------- HERO SEKOLAH ----------
            $row = (new HomeSekolahModel())
                ->where('sekolah_id', $sekolahId)
                ->first();

            if ($row) {
                $home['hero_title']    = $row['hero_title'] ?? null;
                $home['hero_subtitle'] = $row['hero_subtitle'] ?? null;

                for ($i = 1; $i <= 6; $i++) {
                    $key = 'hero_image_' . $i;
                    if (!empty($row[$key])) {
                        $home['hero_images'][] = base_url('uploads/home/' . $row[$key]);
                    }
                }
            }

            // ---------- TENTANG SEKOLAH ----------
            $tentang = (new TentangSekolahModel())
                ->where('sekolah_id', $sekolahId)
                ->first();

            // ---------- VISI MISI SEKOLAH ----------
            if ($type === 'sekolah') {

                $visiMisi = (new VisiMisiSekolahModel())
                    ->where('sekolah_id', $sekolahId)
                    ->where('status', 'publish')
                    ->first();
            }


            // ---------- FASILITAS SEKOLAH ----------
            $fasilitas = (new CmsFasilitasModel())
                ->where('sekolah_id', $sekolahId)
                ->where('is_active', 1)
                ->orderBy('id', 'DESC')
                ->findAll();

            // ---------- EKSKUL SEKOLAH ----------
            $ekskul = (new CmsEkskulModel())
                ->where('sekolah_id', $sekolahId)
                ->orderBy('id', 'DESC')
                ->findAll();

            // ---------- BERITA SEKOLAH ----------
            $beritaTerbaru = (new CmsBeritaModel())
                ->where('level', 'sekolah')
                ->where('sekolah_id', $sekolahId)
                ->where('status', 'publish')
                ->orderBy('created_at', 'DESC')
                ->findAll(3);
        }

        /**
         * ==================================================
         * HOME YAYASAN
         * ==================================================
         */
        else {
            // ---------- STAFF YAYASAN ----------
            $staff = (new CmsStaffModel())
                ->where('level', 'yayasan')
                ->where('status', 'aktif')
                ->orderBy('urutan', 'ASC')
                ->findAll();


            // ---------- HERO YAYASAN ----------
            $row = (new CmsHomeModel())
                ->where('sekolah_id', 0)
                ->first();

            if ($row) {

                $home['hero_title']    = $row['hero_title'] ?? null;
                $home['hero_subtitle'] = $row['hero_subtitle'] ?? null;

                // RESET ARRAY BIAR BERSIH
                $home['hero_images'] = [];

                // 🔒 PASTIKAN NAMA FIELD SESUAI DB YAYASAN
                for ($i = 1; $i <= 6; $i++) {
                    $key = 'hero_image' . $i; // <-- TANPA UNDERSCORE

                    if (isset($row[$key]) && $row[$key] !== '') {
                        $home['hero_images'][] = base_url('uploads/hero/' . $row[$key]);
                    }
                }
            }


            // ---------- TENTANG YAYASAN ----------
            $tentang = (new TentangYayasanModel())
                ->orderBy('id', 'DESC')
                ->first();

            // ---------- VISI MISI YAYASAN ----------
            $visiMisi = (new CmsVisiMisiModel())
                ->where('sekolah_id', 0)
                ->first();

            // ---------- BERITA YAYASAN ----------
            $beritaTerbaru = (new CmsBeritaModel())
                ->where('level', 'yayasan')
                ->where('status', 'publish')
                ->orderBy('created_at', 'DESC')
                ->findAll(3);
        }

        /**
         * ==================================================
         * VIEW
         * ==================================================
         */
        return view('frontend/home/index', [
            'title' => $type === 'sekolah'
                ? 'Beranda | ' . ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah')
                : 'Beranda | ' . ($this->profilYayasan['nama_yayasan'] ?? 'Yayasan'),

            'type'      => $type,
            'context'   => $this->context,

            'home'        => $home,
            'tentang'     => $tentang,
            'staff' => $staff,
            'jurusanHome' => $jurusanHome,
            'visiMisi'    => $visiMisi,
            'fasilitas'   => $fasilitas,
            'ekskul'      => $ekskul,
            'beritaTerbaru' => $beritaTerbaru,
        ]);
    }
}

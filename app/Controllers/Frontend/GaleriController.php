<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use App\Models\CmsGaleriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GaleriController extends FrontendBaseController
{
    protected CmsGaleriModel $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new CmsGaleriModel();
    }

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
         * QUERY SESUAI CONTEXT
         * =========================
         */
        if ($type === 'yayasan') {

            $galeri = $this->galeriModel
                ->where('sekolah_id', 0)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            $title    = 'Galeri Yayasan';
            $subtitle = 'Dokumentasi kegiatan dan momen terbaik Yayasan Galajuara';
        } else {

            $namaSekolah = $this->context['sekolah']['nama_sekolah'] ?? 'Sekolah';

            $galeri = $this->galeriModel
                ->where('sekolah_id', $sekolahId)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            $title    = 'Galeri ' . $namaSekolah;
            $subtitle = 'Dokumentasi kegiatan dan momen terbaik ' . $namaSekolah;
        }

        /**
         * =========================
         * VIEW
         * =========================
         */
        return view('frontend/galeri/index', [
            'title'    => $title,
            'subtitle' => $subtitle,
            'galeri'   => $galeri,
        ]);
    }
}

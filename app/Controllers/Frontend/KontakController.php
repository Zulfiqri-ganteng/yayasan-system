<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Yayasan\ProfilYayasanModel;
use App\Models\ProfilSekolahModel;

class KontakController extends FrontendBaseController
{
    public function index()
    {
        $type      = $this->context['type'];        // yayasan | sekolah
        $sekolahId = (int) $this->context['sekolah_id'];

        $profil = null;

        /**
         * =========================
         * HARD GUARD CONTEXT
         * =========================
         */
        if ($type === 'sekolah' && $sekolahId <= 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        /**
         * =========================
         * DATA KONTAK
         * =========================
         */
        if ($type === 'sekolah') {

            // ---------- PROFIL SEKOLAH ----------
            $profil = (new ProfilSekolahModel())
                ->where('sekolah_id', $sekolahId)
                ->orderBy('updated_at', 'DESC')
                ->first();
        } else {

            // ---------- PROFIL YAYASAN ----------
            $profil = (new ProfilYayasanModel())->first();
        }

        /**
         * =========================
         * NORMALISASI FIELD
         * =========================
         * Agar view tetap pakai:
         * $profil['no_telp']
         */
        if ($profil) {

            // Normalisasi telepon
            if ($type === 'yayasan') {
                $profil['no_telp'] = $profil['telepon'] ?? null;
            }

            // Pastikan field google_maps tetap ada
            $profil['google_maps'] = $profil['google_maps'] ?? null;
        }

        /**
         * =========================
         * VIEW
         * =========================
         */
        return view('frontend/kontak/index', [
            'title' => $type === 'sekolah'
                ? 'Kontak | ' . ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah')
                : 'Kontak | ' . ($this->profilYayasan['nama_yayasan'] ?? 'Yayasan'),

            'type'    => $type,
            'context' => $this->context,
            'profil'  => $profil,
        ]);
    }
}

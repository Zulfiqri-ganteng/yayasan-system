<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use App\Models\CmsBeritaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BeritaController extends FrontendBaseController
{
    /**
     * =========================
     * LIST BERITA
     * =========================
     */
    public function index()
    {
        $type      = $this->context['type'];        // yayasan | sekolah
        $sekolahId = (int) $this->context['sekolah_id'];

        $model = new CmsBeritaModel();

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
         * QUERY BERDASARKAN CONTEXT
         * =========================
         */
        if ($type === 'yayasan') {

            $berita = $model
                ->where('level', 'yayasan')
                ->where('status', 'publish')
                ->orderBy('created_at', 'DESC')
                ->paginate(6);

            $title = 'Berita Yayasan';
        } else {
            $berita = $model
                ->where('level', 'sekolah')
                ->where('sekolah_id', $sekolahId)
                ->where('status', 'publish')
                ->orderBy('created_at', 'DESC')
                ->paginate(6);

            $title = 'Berita ' . ($this->context['sekolah']['nama_sekolah'] ?? 'Sekolah');
        }

        /**
         * =========================
         * VIEW
         * =========================
         */

        return view('frontend/berita/index', [
            'title'   => $title,
            'berita'  => $berita,
            'pager'   => $model->pager,
            'context' => $this->context,
        ]);
    }

    /**
     * =========================
     * DETAIL BERITA
     * =========================
     */
    public function detail(string $slug)
    {
        $type      = $this->context['type'];
        $sekolahId = (int) $this->context['sekolah_id'];

        $model = new CmsBeritaModel();

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
         * QUERY BERITA SESUAI CONTEXT
         * =========================
         */
        if ($type === 'yayasan') {

            $berita = $model
                ->where('slug', $slug)
                ->where('level', 'yayasan')
                ->where('status', 'publish')
                ->first();
        } else {

            $berita = $model
                ->where('slug', $slug)
                ->where('level', 'sekolah')
                ->where('sekolah_id', $sekolahId)
                ->where('status', 'publish')
                ->first();
        }

        /**
         * =========================
         * JIKA TIDAK SESUAI CONTEXT
         * =========================
         */
        if (!$berita) {
            throw PageNotFoundException::forPageNotFound();
        }

        /**
         * =========================
         * VIEW
         * =========================
         */
        return view('frontend/berita/detail', [
            'title'   => $berita['judul'],
            'berita'  => $berita,
            'context' => $this->context,
        ]);
    }
}

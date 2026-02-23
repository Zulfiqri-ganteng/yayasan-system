<?php

namespace App\Controllers\Frontend;

use App\Models\Sekolah\EkstrakurikulerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EkstrakurikulerController extends FrontendBaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new EkstrakurikulerModel();
    }

    // ===========================
    // LIST EKSTRAKURIKULER
    // ===========================
    public function index()
    {
        // 🔒 Harus sekolah
        if ($this->context['type'] !== 'sekolah') {
            throw PageNotFoundException::forPageNotFound();
        }

        $ekskul = $this->model
            ->where('sekolah_id', $this->context['sekolah_id'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('frontend/kesiswaan/ekstrakurikuler/index', [
            'ekskul' => $ekskul
        ]);
    }

    // ===========================
    // DETAIL EKSTRAKURIKULER
    // ===========================
    public function detail($slug)
    {
        if ($this->context['type'] !== 'sekolah') {
            throw PageNotFoundException::forPageNotFound();
        }

        $ekskul = $this->model
            ->where('slug', $slug)
            ->where('sekolah_id', $this->context['sekolah_id'])
            ->where('status', 'publish')
            ->first();

        if (!$ekskul) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('frontend/kesiswaan/ekstrakurikuler/detail', [
            'ekskul' => $ekskul
        ]);
    }
}
<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use App\Models\CmsPengumumanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PengumumanController extends FrontendBaseController
{
    protected CmsPengumumanModel $model;

    public function __construct()
    {
        $this->model = new CmsPengumumanModel();
    }

    public function index()
    {
        $type      = $this->context['type'];
        $sekolahId = (int) ($this->context['sekolah_id'] ?? 0);

        $pengumuman = $this->model
            ->where('status', 'publish')
            ->where(
                $type === 'sekolah'
                    ? ['sekolah_id' => $sekolahId]
                    : ['sekolah_id' => 0]
            )
            ->orderBy('tanggal_publish', 'DESC')
            ->findAll();

        return view('frontend/pengumuman/index', [
            'title'      => 'Pengumuman',
            'pengumuman' => $pengumuman,
        ]);
    }

    public function detail($id)
    {
        $type      = $this->context['type'];
        $sekolahId = (int) ($this->context['sekolah_id'] ?? 0);

        $pengumuman = $this->model
            ->where('id', $id)
            ->where('status', 'publish')
            ->where(
                $type === 'sekolah'
                    ? ['sekolah_id' => $sekolahId]
                    : ['sekolah_id' => 0]
            )
            ->first();

        if (!$pengumuman) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('frontend/pengumuman/detail', [
            'title'       => $pengumuman['judul'],
            'pengumuman'  => $pengumuman, // <-- samakan nama
        ]);
    }
}

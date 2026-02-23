<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\TentangSekolahModel;

class TentangController extends BaseController
{
    protected TentangSekolahModel $model;

    public function __construct()
    {
        $this->model = new TentangSekolahModel();
    }

    /**
     * =========================
     * CMS TENTANG SEKOLAH
     * =========================
     */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        // 🔒 HARD GUARD
        if (!$sekolahId) {
            return redirect()->to('/login');
        }

        $data = $this->model
            ->where('sekolah_id', $sekolahId)
            ->first();

        return view('sekolah/cms/tentang/index', [
            'data' => $data
        ]);
    }

    /**
     * =========================
     * SIMPAN / UPDATE
     * =========================
     */
    public function save()
    {
        $sekolahId = session()->get('sekolah_id');

        // 🔒 HARD GUARD
        if (!$sekolahId) {
            return redirect()->to('/login');
        }

        $existing = $this->model
            ->where('sekolah_id', $sekolahId)
            ->first();

        $payload = [
            'sekolah_id' => $sekolahId,
            'judul'      => $this->request->getPost('judul'),
            'konten'     => $this->request->getPost('konten'),
            'status'     => 'publish',
        ];

        /**
         * =========================
         * HANDLE BANNER IMAGE
         * =========================
         */
        $banner = $this->request->getFile('banner_image');

        if ($banner && $banner->isValid() && !$banner->hasMoved()) {

            $uploadPath = FCPATH . 'uploads/sekolah/';

            // ⛔ Pastikan folder ada
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // 🧹 HAPUS FILE LAMA (JIKA ADA)
            if ($existing && !empty($existing['banner_image'])) {
                $oldFile = $uploadPath . $existing['banner_image'];
                if (is_file($oldFile)) {
                    unlink($oldFile);
                }
            }

            // ⬆️ UPLOAD BARU
            $newName = $banner->getRandomName();
            $banner->move($uploadPath, $newName);

            $payload['banner_image'] = $newName;
        }

        /**
         * =========================
         * SAVE DATA
         * =========================
         */
        if ($existing) {
            $this->model->update($existing['id'], $payload);
        } else {
            $this->model->insert($payload);
        }

        return redirect()
            ->back()
            ->with('success', 'Tentang Sekolah berhasil disimpan');
    }
}

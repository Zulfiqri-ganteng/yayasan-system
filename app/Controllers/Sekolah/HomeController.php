<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\HomeSekolahModel;

class HomeController extends BaseController
{
    protected $homeModel;
    protected string $uploadPath;

    public function __construct()
    {
        $this->homeModel  = new HomeSekolahModel();
        $this->uploadPath = FCPATH . 'uploads/home/';
    }

    /**
     * CMS Beranda Sekolah
     * URL: /sekolah/home
     */
    public function index()
    {
        $sekolahId = session('sekolah_id');

        $home = $this->homeModel
            ->where('sekolah_id', $sekolahId)
            ->first();

        return view('sekolah/home/index', [
            'title' => 'CMS Beranda Sekolah',
            'home'  => $home
        ]);
    }

    /**
     * Simpan CMS Beranda Sekolah
     * URL: POST /sekolah/home/simpan
     */
    public function simpan()
    {
        $sekolahId = session('sekolah_id');

        $data = [
            'sekolah_id'    => $sekolahId,
            'hero_title'    => $this->request->getPost('hero_title'),
            'hero_subtitle' => $this->request->getPost('hero_subtitle'),
        ];

        // Ambil data lama (kalau ada)
        $existing = $this->homeModel
            ->where('sekolah_id', $sekolahId)
            ->first();

        /**
         * ===============================
         * UPLOAD HERO IMAGE (1 - 6)
         * ===============================
         */
        for ($i = 1; $i <= 6; $i++) {

            $field = 'hero_image_' . $i;
            $file  = $this->request->getFile($field);

            if ($file && $file->isValid() && !$file->hasMoved()) {

                // 🔥 HAPUS FILE LAMA SLOT YANG SAMA
                if ($existing && !empty($existing[$field])) {
                    $oldPath = $this->uploadPath . $existing[$field];
                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // SIMPAN FILE BARU
                $newName = 'hero_' . $sekolahId . '_' . $i . '_' . time() . '.' . $file->getExtension();
                $file->move($this->uploadPath, $newName);

                $data[$field] = $newName;
            }
            $deleteFlag = $this->request->getPost('delete_hero_image_' . $i);

            if ($deleteFlag && $existing && !empty($existing[$field])) {
                $oldPath = $this->uploadPath . $existing[$field];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
                $data[$field] = null;
                continue; // skip upload slot ini
            }
        }

        if ($existing) {
            // Guard tambahan (aman)
            if ((int)$existing['sekolah_id'] !== (int)$sekolahId) {
                return redirect()->back()->with('error', 'Akses tidak valid');
            }

            $this->homeModel->update($existing['id'], $data);
        } else {
            $this->homeModel->insert($data);
        }

        return redirect()->back()
            ->with('success', 'Beranda sekolah berhasil disimpan');
    }
}

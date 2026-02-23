<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\CmsHomeModel;

class HomeController extends BaseController
{
    protected CmsHomeModel $model;

    public function __construct()
    {
        $this->model = new CmsHomeModel();
    }

    public function index()
    {
        // ✅ YAYASAN WAJIB 0
        $sekolahId = 0;

        $home = $this->model
            ->where('sekolah_id', $sekolahId)
            ->first();

        return view('admin/yayasan/home/index', [
            'title' => 'CMS Beranda Yayasan',
            'home'  => $home,
        ]);
    }

    public function save()
    {
        // ✅ YAYASAN WAJIB 0
        $sekolahId = 0;

        $existing = $this->model
            ->where('sekolah_id', $sekolahId)
            ->first();

        $data = [
            'sekolah_id'    => $sekolahId,
            'hero_title'    => $this->request->getPost('hero_title'),
            'hero_subtitle' => $this->request->getPost('hero_subtitle'),
        ];

        /**
         * ================================
         * HANDLE HERO IMAGE (1 - 6)
         * ================================
         */
        for ($i = 1; $i <= 6; $i++) {

            $field = 'hero_image' . $i;
            $file  = $this->request->getFile($field);

            if ($file && $file->isValid() && !$file->hasMoved()) {

                // 🔥 HAPUS FILE LAMA JIKA ADA
                if ($existing && !empty($existing[$field])) {
                    $oldPath = FCPATH . 'uploads/hero/' . $existing[$field];
                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // 🔒 NAMA FILE KONSISTEN & AMAN
                $newName = 'hero_yayasan_' . $i . '_' . time() . '.' . $file->getExtension();
                $file->move(FCPATH . 'uploads/hero', $newName);

                $data[$field] = $newName;
            }
        }

        // ================================
        // INSERT / UPDATE
        // ================================
        if ($existing) {
            $this->model->update($existing['id'], $data);
        } else {
            $this->model->insert($data);
        }

        return redirect()->back()->with('success', 'Beranda Yayasan berhasil disimpan');
    }
}

<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\Yayasan\TentangYayasanModel;
use App\Models\Yayasan\SejarahYayasanModel;

class TentangController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TentangYayasanModel();
        $this->sejarahModel = new SejarahYayasanModel();
    }

    public function index()
    {
        return view('admin/yayasan/tentang/index', [
            'title' => 'Tentang Yayasan',
            'data'  => $this->model->first()
        ]);
    }

    public function save()
    {
        $data = $this->request->getPost();

        // Ambil data lama (1 baris saja untuk yayasan)
        $existing = $this->model->first();

        /**
         * ===============================
         * UPLOAD FOTO DIREKTUR
         * ===============================
         */
        $foto = $this->request->getFile('foto_direktur');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // 🔥 HAPUS FOTO LAMA
            if ($existing && !empty($existing['foto_direktur'])) {
                $oldPath = FCPATH . 'uploads/yayasan/' . $existing['foto_direktur'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // SIMPAN FOTO BARU
            $newName = 'direktur_' . time() . '.' . $foto->getExtension();
            $foto->move(FCPATH . 'uploads/yayasan', $newName);
            $data['foto_direktur'] = $newName;
        }

        /**
         * ===============================
         * UPLOAD BANNER IMAGE
         * ===============================
         */
        $banner = $this->request->getFile('banner_image');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {

            // 🔥 HAPUS BANNER LAMA
            if ($existing && !empty($existing['banner_image'])) {
                $oldPath = FCPATH . 'uploads/yayasan/' . $existing['banner_image'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // SIMPAN BANNER BARU
            $newName = 'banner_' . time() . '.' . $banner->getExtension();
            $banner->move(FCPATH . 'uploads/yayasan', $newName);
            $data['banner_image'] = $newName;
        }

        /**
         * ===============================
         * INSERT / UPDATE
         * ===============================
         */
        if ($existing) {
            $this->model->update($existing['id'], $data);
        } else {
            $this->model->insert($data);
        }

        return redirect()->back()->with('success', 'Tentang Yayasan berhasil disimpan');
    }
}

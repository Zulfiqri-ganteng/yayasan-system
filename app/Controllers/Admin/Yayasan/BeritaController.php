<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\CmsBeritaModel;

class BeritaController extends BaseController
{
    protected CmsBeritaModel $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new CmsBeritaModel();
    }

    public function index()
    {
        return view('admin/yayasan/berita/index', [
            'title'  => 'Berita Yayasan',
            'berita' => $this->beritaModel
                ->where('level', 'yayasan')
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/yayasan/berita/create', [
            'title' => 'Tambah Berita Yayasan',
        ]);
    }

    public function store()
    {
        $judul = $this->request->getPost('judul');
        $slug  = url_title($judul, '-', true);

        $data = [
            'level'        => 'yayasan',
            'judul'        => $judul,
            'slug'         => $slug,
            'ringkasan'    => $this->request->getPost('ringkasan'),
            'konten'       => $this->request->getPost('konten'),
            'status'       => $this->request->getPost('status'),
            'is_highlight' => 0,
        ];

        // ===============================
        // UPLOAD FEATURED IMAGE
        // ===============================
        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = 'berita_yayasan_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/berita', $name);
            $data['featured_image'] = $name;
        }

        $this->beritaModel->insert($data);

        return redirect()->to('admin/yayasan/berita')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = $this->beritaModel->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data berita tidak ditemukan');
        }

        return view('admin/yayasan/berita/edit', [
            'title' => 'Edit Berita',
            'data'  => $data
        ]);
    }

    public function update($id)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'judul'  => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status'),
        ];

        /**
         * ================================
         * HANDLE FEATURED IMAGE (EDIT)
         * ================================
         */
        $file = $this->request->getFile('featured_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🔥 HAPUS FILE LAMA
            if (!empty($berita['featured_image'])) {
                $oldPath = FCPATH . 'uploads/berita/' . $berita['featured_image'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // SIMPAN FILE BARU
            $newName = 'berita_yayasan_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/berita', $newName);

            $data['featured_image'] = $newName;
        }

        $this->beritaModel->update($id, $data);

        return redirect()->to('admin/yayasan/berita')
            ->with('success', 'Berita berhasil diperbarui');
    }


    public function delete($id)
    {
        $data = $this->beritaModel->find($id);

        if ($data && !empty($data['featured_image'])) {
            $path = FCPATH . 'uploads/berita/' . $data['featured_image'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->beritaModel->delete($id);

        return redirect()->back()
            ->with('success', 'Berita berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $data = $this->beritaModel->find($id);

        if (!$data) {
            return redirect()->back();
        }

        $this->beritaModel->update($id, [
            'status' => $data['status'] === 'publish' ? 'draft' : 'publish'
        ]);

        return redirect()->back();
    }
}

<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\BeritaSekolahModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BeritaController extends BaseController
{
    protected BeritaSekolahModel $model;

    public function __construct()
    {
        $this->model = new BeritaSekolahModel();
    }

    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        $berita = $this->model
            ->where('level', 'sekolah')
            ->where('sekolah_id', $sekolahId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('sekolah/berita/index', [
            'berita' => $berita
        ]);
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create()
    {
        return view('sekolah/berita/create');
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store()
    {
        $sekolahId = session()->get('sekolah_id');
        $judul     = $this->request->getPost('judul');

        $uploadPath = FCPATH . 'uploads/berita/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $data = [
            'sekolah_id' => $sekolahId,
            'level'      => 'sekolah',
            'judul'      => $judul,
            'slug'       => url_title($judul, '-', true),
            'ringkasan'  => $this->request->getPost('ringkasan'),
            'konten'     => $this->request->getPost('konten'),
            'status'     => $this->request->getPost('status'),
        ];

        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move($uploadPath, $name);
            $data['featured_image'] = $name;
        }

        $this->model->insert($data);

        return redirect()->to('/sekolah/berita')
            ->with('success', 'Berita sekolah berhasil ditambahkan');
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $berita = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if (!$berita) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/berita/edit', [
            'berita' => $berita
        ]);
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $dataLama = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if (!$dataLama) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'judul'  => 'required|min_length[5]',
            'konten' => 'required',
            'featured_image' => [
                'rules' => 'if_exist|max_size[featured_image,2048]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'judul'  => $this->request->getPost('judul'),
            'slug'   => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status'),
        ];

        $uploadPath = FCPATH . 'uploads/berita/';
        $file = $this->request->getFile('featured_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🧹 HAPUS FOTO LAMA
            if (!empty($dataLama['featured_image'])) {
                $oldPath = $uploadPath . $dataLama['featured_image'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $updateData['featured_image'] = $newName;
        }

        $this->model->update($id, $updateData);

        return redirect()->to('/sekolah/berita')
            ->with('success', 'Berita berhasil diperbarui');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $berita = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if ($berita) {
            if (!empty($berita['featured_image'])) {
                $path = FCPATH . 'uploads/berita/' . $berita['featured_image'];
                if (is_file($path)) {
                    unlink($path);
                }
            }

            $this->model->delete($id);
        }

        return redirect()->back()
            ->with('success', 'Berita sekolah berhasil dihapus');
    }
}

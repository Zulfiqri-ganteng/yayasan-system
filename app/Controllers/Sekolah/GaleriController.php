<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\GaleriSekolahModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GaleriController extends BaseController
{
    protected GaleriSekolahModel $galeri;

    public function __construct()
    {
        $this->galeri = new GaleriSekolahModel();
    }

    /* ================= INDEX ================= */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        $data = [
            'title'  => 'Galeri Sekolah',
            'galeri' => $this->galeri
                ->where('sekolah_id', $sekolahId)
                ->orderBy('id', 'DESC')
                ->findAll()
        ];

        return view('sekolah/galeri/index', $data);
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('sekolah/galeri/create');
    }

    /* ================= STORE ================= */
    public function store()
    {
        $sekolahId = session()->get('sekolah_id');
        $file      = $this->request->getFile('gambar');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return back()->with('error', 'File tidak valid');
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            return back()->with('error', 'Ukuran gambar maksimal 2MB');
        }

        $allowedMime = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/heic',
            'image/heif'
        ];

        if (!in_array($file->getMimeType(), $allowedMime, true)) {
            return back()->with('error', 'Format gambar tidak didukung');
        }

        $uploadPath = FCPATH . 'uploads/sekolah/galeri/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $this->galeri->insert([
            'sekolah_id' => $sekolahId,
            'judul'      => $this->request->getPost('judul'),
            'gambar'     => $newName,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/sekolah/galeri')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $row = $this->galeri
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$row) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/galeri/edit', [
            'row' => $row
        ]);
    }

    /* ================= UPDATE ================= */
    public function update($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $row = $this->galeri
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$row) {
            throw PageNotFoundException::forPageNotFound();
        }

        $dataUpdate = [
            'judul' => $this->request->getPost('judul')
        ];

        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if ($file->getSize() > 2 * 1024 * 1024) {
                return back()->with('error', 'Ukuran gambar maksimal 2MB');
            }

            $allowedMime = [
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/heic',
                'image/heif'
            ];

            if (!in_array($file->getMimeType(), $allowedMime, true)) {
                return back()->with('error', 'Format gambar tidak didukung');
            }

            $uploadPath = FCPATH . 'uploads/sekolah/galeri/';

            // 🧹 HAPUS FOTO LAMA
            if (!empty($row['gambar'])) {
                $oldPath = $uploadPath . $row['gambar'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $dataUpdate['gambar'] = $newName;
        }

        $this->galeri->update($id, $dataUpdate);

        return redirect()->to('/sekolah/galeri')
            ->with('success', 'Galeri berhasil diperbarui');
    }

    /* ================= DELETE ================= */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $row = $this->galeri
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if ($row) {
            $path = FCPATH . 'uploads/sekolah/galeri/' . $row['gambar'];
            if (!empty($row['gambar']) && is_file($path)) {
                unlink($path);
            }

            $this->galeri->delete($id);
        }

        return redirect()->back()
            ->with('success', 'Galeri berhasil dihapus');
    }
}

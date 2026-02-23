<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\Yayasan\GaleriYayasanModel;

class GaleriYayasan extends BaseController
{
    protected $galeri;

    public function __construct()
    {
        $this->galeri = new GaleriYayasanModel();
    }

    public function index()
    {
        $data['title']  = 'Galeri Yayasan';
        $data['galeri'] = $this->galeri
            ->where('sekolah_id', 0) // 0 = yayasan
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/yayasan/galeri/index', $data);
    }

    public function create()
    {
        return view('admin/yayasan/galeri/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'judul' => 'required|min_length[3]',
            'gambar' => [
                'rules' => 'uploaded[gambar]'
                    . '|is_image[gambar]'
                    . '|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[gambar,2048]',
                'errors' => [
                    'uploaded' => 'Gambar wajib diisi',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format gambar tidak valid',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $namaFile = $file->getRandomName();
        $file->move('uploads/galeri', $namaFile);

        $this->galeri->insert([
            'sekolah_id' => 0,
            'judul'      => $this->request->getPost('judul'),
            'gambar'     => $namaFile,
        ]);

        return redirect()->to('admin/yayasan/galeri')
            ->with('success', 'Galeri berhasil ditambahkan');
    }


    public function edit($id)
    {
        $data['galeri'] = $this->galeri->find($id);
        return view('admin/yayasan/galeri/edit', $data);
    }

    public function update($id)
    {
        $galeri = $this->galeri->find($id);

        if (!$galeri) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'judul' => 'required|min_length[3]',
            'gambar' => [
                'rules' => 'if_exist'
                    . '|is_image[gambar]'
                    . '|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[gambar,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format gambar tidak valid',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
        ];

        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🧹 Hapus file lama
            $path = 'uploads/galeri/' . $galeri['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }

            // ⬆️ Upload baru
            $namaFile = $file->getRandomName();
            $file->move('uploads/galeri', $namaFile);

            $data['gambar'] = $namaFile;
        }

        $this->galeri->update($id, $data);

        return redirect()->to('admin/yayasan/galeri')
            ->with('success', 'Galeri berhasil diperbarui');
    }


    public function delete($id)
    {
        $galeri = $this->galeri->find($id);

        if ($galeri && !empty($galeri['gambar'])) {
            $path = FCPATH . 'uploads/galeri/' . $galeri['gambar'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->galeri->delete($id);

        return redirect()->back()
            ->with('success', 'Galeri berhasil dihapus');
    }
}

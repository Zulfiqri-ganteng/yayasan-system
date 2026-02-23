<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\CmsJurusanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class JurusanController extends BaseController
{
    protected $jurusanModel;
    protected $sekolahId;
    protected $jenjang;

    public function __construct()
    {
        $this->jurusanModel = new CmsJurusanModel();
        $this->sekolahId    = session()->get('sekolah_id');
        $this->jenjang      = session()->get('jenjang');

        // 🔒 WAJIB SMK
        if ($this->jenjang !== 'smk') {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['jurusan'] = $this->jurusanModel
            ->where('sekolah_id', $this->sekolahId)
            ->orderBy('urutan', 'ASC')
            ->findAll();

        return view('admin/sekolah/jurusan/index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin/sekolah/jurusan/create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama jurusan wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.'
                ]
            ],
            'foto_cover' => [
                'rules' => 'uploaded[foto_cover]|is_image[foto_cover]|max_size[foto_cover,2048]',
                'errors' => [
                    'uploaded' => 'Foto cover wajib diupload.',
                    'is_image' => 'File harus berupa gambar.',
                    'max_size' => 'Ukuran maksimal 2MB.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validation->getErrors());
        }

        // 🔹 Upload Foto
        $foto     = $this->request->getFile('foto_cover');
        $namaFile = $foto->getRandomName();

        $uploadPath = FCPATH . 'uploads/sekolah/jurusan/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $foto->move($uploadPath, $namaFile);

        // 🔹 Insert Data
        $this->jurusanModel->insert([
            'sekolah_id' => $this->sekolahId,
            'nama'       => $this->request->getPost('nama'),
            'slug'       => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'foto_cover' => $namaFile,
            'urutan'     => $this->request->getPost('urutan') ?? 0,
            'status'     => $this->request->getPost('status') ?? 'draft',
        ]);

        return redirect()->to('sekolah/jurusan')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $jurusan = $this->jurusanModel
            ->where('id', $id)
            ->where('sekolah_id', $this->sekolahId)
            ->first();

        if (!$jurusan) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/sekolah/jurusan/edit', [
            'jurusan' => $jurusan
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update($id)
    {
        $jurusan = $this->jurusanModel
            ->where('id', $id)
            ->where('sekolah_id', $this->sekolahId)
            ->first();

        if (!$jurusan) {
            throw PageNotFoundException::forPageNotFound();
        }

        $namaFile = $jurusan['foto_cover'];
        $uploadPath = FCPATH . 'uploads/sekolah/jurusan/';

        // 🔹 Cek jika upload foto baru
        $foto = $this->request->getFile('foto_cover');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            $namaFileBaru = $foto->getRandomName();
            $foto->move($uploadPath, $namaFileBaru);

            // 🔥 Hapus foto lama
            if (
                !empty($jurusan['foto_cover']) &&
                file_exists($uploadPath . $jurusan['foto_cover'])
            ) {
                unlink($uploadPath . $jurusan['foto_cover']);
            }

            $namaFile = $namaFileBaru;
        }

        $this->jurusanModel->update($id, [
            'nama'       => $this->request->getPost('nama'),
            'slug'       => url_title($this->request->getPost('nama'), '-', true),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'foto_cover' => $namaFile,
            'urutan'     => $this->request->getPost('urutan') ?? 0,
            'status'     => $this->request->getPost('status') ?? 'draft',
        ]);

        return redirect()->to('sekolah/jurusan')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id)
    {
        $jurusan = $this->jurusanModel
            ->where('id', $id)
            ->where('sekolah_id', $this->sekolahId)
            ->first();

        if ($jurusan) {

            $uploadPath = FCPATH . 'uploads/sekolah/jurusan/';

            if (
                !empty($jurusan['foto_cover']) &&
                file_exists($uploadPath . $jurusan['foto_cover'])
            ) {
                unlink($uploadPath . $jurusan['foto_cover']);
            }

            $this->jurusanModel->delete($id);
        }

        return redirect()->to('sekolah/jurusan')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}

<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\CmsFasilitasModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class FasilitasController extends BaseController
{
    protected CmsFasilitasModel $fasilitasModel;

    public function __construct()
    {
        $this->fasilitasModel = new CmsFasilitasModel();
    }

    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        if (!$sekolahId) {
            return redirect()->to('/login');
        }

        return view('sekolah/fasilitas/index', [
            'title'     => 'Fasilitas Sekolah',
            'fasilitas' => $this->fasilitasModel
                ->where('sekolah_id', $sekolahId)
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ]);
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create()
    {
        $sekolahId = session()->get('sekolah_id');

        if (!$sekolahId) {
            return redirect()->to('/login');
        }

        // BATAS 10 DATA
        $total = $this->fasilitasModel
            ->where('sekolah_id', $sekolahId)
            ->countAllResults();

        if ($total >= 10) {
            return redirect()->back()
                ->with('error', 'Maksimal 10 fasilitas per sekolah');
        }

        return view('sekolah/fasilitas/form', [
            'title' => 'Tambah Fasilitas',
        ]);
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store()
    {
        $sekolahId = session()->get('sekolah_id');

        if (!$sekolahId) {
            return redirect()->to('/login');
        }

        $uploadPath = FCPATH . 'uploads/fasilitas/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file     = $this->request->getFile('gambar');
        $namaFile = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move($uploadPath, $namaFile);
        }

        $this->fasilitasModel->insert([
            'sekolah_id'     => $sekolahId,
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'gambar'         => $namaFile,
            'is_active'      => 1,
        ]);

        return redirect()->to('/sekolah/fasilitas')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->fasilitasModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$data) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/fasilitas/form', [
            'title' => 'Edit Fasilitas',
            'data'  => $data,
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

        $data = $this->fasilitasModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$data) {
            throw PageNotFoundException::forPageNotFound();
        }

        $uploadPath = FCPATH . 'uploads/fasilitas/';
        $file       = $this->request->getFile('gambar');
        $namaFile   = $data['gambar'];

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🧹 HAPUS FILE LAMA
            if ($namaFile && is_file($uploadPath . $namaFile)) {
                unlink($uploadPath . $namaFile);
            }

            $namaFile = $file->getRandomName();
            $file->move($uploadPath, $namaFile);
        }

        $this->fasilitasModel->update($id, [
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'gambar'         => $namaFile,
        ]);

        return redirect()->to('/sekolah/fasilitas')
            ->with('success', 'Fasilitas berhasil diperbarui');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->fasilitasModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if ($data) {
            $path = FCPATH . 'uploads/fasilitas/' . $data['gambar'];
            if (!empty($data['gambar']) && is_file($path)) {
                unlink($path);
            }

            $this->fasilitasModel->delete($id);
        }

        return redirect()->back()
            ->with('success', 'Fasilitas dihapus');
    }
}

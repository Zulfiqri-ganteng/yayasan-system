<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\CmsAkademikModel;

class AkademikController extends BaseController
{
    protected $akademikModel;

    protected string $uploadPath;

    public function __construct()
    {
        $this->akademikModel = new CmsAkademikModel();
        $this->uploadPath   = FCPATH . 'uploads/akademik/';
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        return view('admin/yayasan/akademik/index', [
            'title'    => 'Akademik Yayasan',
            'akademik' => $this->akademikModel->findAll()
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('admin/yayasan/akademik/create', [
            'title' => 'Tambah Akademik',
            'data'  => null
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $data = $this->request->getPost();

        // FOTO SEKOLAH
        $fotoSekolah = $this->request->getFile('foto_sekolah');
        if ($fotoSekolah && $fotoSekolah->isValid() && !$fotoSekolah->hasMoved()) {
            $namaFoto = $fotoSekolah->getRandomName();
            $fotoSekolah->move($this->uploadPath, $namaFoto);
            $data['foto_sekolah'] = $namaFoto;
        }

        // FOTO KEPALA SEKOLAH
        $fotoKepsek = $this->request->getFile('foto_kepsek');
        if ($fotoKepsek && $fotoKepsek->isValid() && !$fotoKepsek->hasMoved()) {
            $namaFoto = $fotoKepsek->getRandomName();
            $fotoKepsek->move($this->uploadPath, $namaFoto);
            $data['foto_kepsek'] = $namaFoto;
        }

        $this->akademikModel->insert($data);

        return redirect()->to('/admin/yayasan/akademik')
            ->with('success', 'Data akademik berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        return view('admin/yayasan/akademik/edit', [
            'title' => 'Edit Akademik',
            'data'  => $this->akademikModel->find($id)
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $row = $this->akademikModel->find($id);

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();

        // FOTO SEKOLAH
        $fotoSekolah = $this->request->getFile('foto_sekolah');
        if ($fotoSekolah && $fotoSekolah->isValid() && !$fotoSekolah->hasMoved()) {

            if (!empty($row['foto_sekolah'])) {
                $oldPath = $this->uploadPath . $row['foto_sekolah'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $namaFoto = $fotoSekolah->getRandomName();
            $fotoSekolah->move($this->uploadPath, $namaFoto);
            $data['foto_sekolah'] = $namaFoto;
        }

        // FOTO KEPALA SEKOLAH
        $fotoKepsek = $this->request->getFile('foto_kepsek');
        if ($fotoKepsek && $fotoKepsek->isValid() && !$fotoKepsek->hasMoved()) {

            if (!empty($row['foto_kepsek'])) {
                $oldPath = $this->uploadPath . $row['foto_kepsek'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $namaFoto = $fotoKepsek->getRandomName();
            $fotoKepsek->move($this->uploadPath, $namaFoto);
            $data['foto_kepsek'] = $namaFoto;
        }

        $this->akademikModel->update($id, $data);

        return redirect()->to('/admin/yayasan/akademik')
            ->with('success', 'Data akademik berhasil diperbarui');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $row = $this->akademikModel->find($id);

        if ($row) {
            foreach (['foto_sekolah', 'foto_kepsek'] as $field) {
                if (!empty($row[$field])) {
                    $path = $this->uploadPath . $row[$field];
                    if (is_file($path)) {
                        unlink($path);
                    }
                }
            }
        }

        $this->akademikModel->delete($id);

        return redirect()->back()
            ->with('success', 'Data akademik berhasil dihapus');
    }
}

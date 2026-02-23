<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\FiturJenjangModel;
use App\Models\SekolahFiturModel; 
class SekolahController extends BaseController
{
    protected $sekolahModel;
    protected $fiturJenjangModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
        $this->fiturJenjangModel = new FiturJenjangModel();
        $this->sekolahFiturModel = new SekolahFiturModel();
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        return view('admin/sekolah/index', [
            'title'   => 'Manajemen Sekolah',
            'sekolah' => $this->sekolahModel->orderBy('id', 'ASC')->findAll()
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('admin/sekolah/create', [
            'title' => 'Tambah Sekolah'
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $jenjang = strtolower($this->request->getPost('jenjang'));

        // ===============================
        // 1️⃣ SIMPAN SEKOLAH
        // ===============================
        $sekolahId = $this->sekolahModel->insert([
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'jenjang'      => $jenjang,
            'status'       => 1,
        ], true); // TRUE → ambil insertID

        // ===============================
        // 2️⃣ AUTO GENERATE FITUR (A.4-3)
        // ===============================
        $fiturJenjangModel = new FiturJenjangModel();
        $sekolahFiturModel = new SekolahFiturModel();

        $fiturDefault = $fiturJenjangModel
            ->where('jenjang', $jenjang)
            ->findAll();

        foreach ($fiturDefault as $f) {

            // 🔒 CEGAH DUPLIKAT
            $exist = $sekolahFiturModel
                ->where('sekolah_id', $sekolahId)
                ->where('fitur_kode', $f['fitur_kode'])
                ->first();

            if (!$exist) {
                $sekolahFiturModel->insert([
                    'sekolah_id' => $sekolahId,
                    'fitur_kode' => $f['fitur_kode'],
                    'aktif'      => $f['aktif']
                ]);
            }
        }

        // ===============================
        // 3️⃣ REDIRECT
        // ===============================
        return redirect()->to('/admin/sekolah')
            ->with('success', 'Sekolah & fitur default berhasil ditambahkan');
    }


    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $sekolah = $this->sekolahModel->find($id);

        if (!$sekolah) {
            return redirect()->to('/admin/sekolah')
                ->with('error', 'Data tidak ditemukan');
        }

        // 🔒 BLOK YAYASAN
        if (strtolower($sekolah['jenjang']) === 'yayasan') {
            return redirect()->to('/admin/sekolah')
                ->with('error', 'Data yayasan tidak dapat diedit');
        }

        return view('admin/sekolah/edit', [
            'title'   => 'Edit Sekolah',
            'sekolah' => $sekolah
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $sekolah = $this->sekolahModel->find($id);

        if (!$sekolah || strtolower($sekolah['jenjang']) === 'yayasan') {
            return redirect()->to('/admin/sekolah');
        }

        $this->sekolahModel->update($id, [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'jenjang'      => strtolower($this->request->getPost('jenjang')),
        ]);

        return redirect()->to('/admin/sekolah')
            ->with('success', 'Data sekolah diperbarui');
    }

    // =========================
    // AKTIF / NONAKTIF (FINAL)
    // =========================
    public function toggle($id)
    {
        $sekolah = $this->sekolahModel->find($id);

        if (!$sekolah) {
            return redirect()->back()
                ->with('error', 'Data tidak ditemukan');
        }

        // 🔒 PROTEKSI YAYASAN (FINAL)
        if (strtolower($sekolah['jenjang']) === 'yayasan') {
            return redirect()->back()
                ->with('error', 'Yayasan tidak dapat diubah statusnya');
        }

        $this->sekolahModel->update($id, [
            'status' => $sekolah['status'] == 1 ? 0 : 1
        ]);

        return redirect()->back()
            ->with('success', 'Status sekolah diperbarui');
    }
}

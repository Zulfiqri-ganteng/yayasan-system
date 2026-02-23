<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\CmsStaffModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class StaffController extends BaseController
{
    protected CmsStaffModel $staffModel;

    public function __construct()
    {
        $this->staffModel = new CmsStaffModel();
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

        $staff = $this->staffModel
            ->where('level', 'sekolah')
            ->where('sekolah_id', $sekolahId)
            ->orderBy('urutan', 'ASC')
            ->findAll();

        return view('sekolah/staff/index', [
            'title' => 'Staff Sekolah',
            'staff' => $staff
        ]);
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create()
    {
        return view('sekolah/staff/create', [
            'title' => 'Tambah Staff Sekolah'
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

        $uploadPath = FCPATH . 'uploads/staff/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $foto     = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move($uploadPath, $fotoName);
        }

        $this->staffModel->insert([
            'sekolah_id' => $sekolahId,
            'level'      => 'sekolah',
            'nama'       => $this->request->getPost('nama'),
            'jabatan'    => $this->request->getPost('jabatan'),
            'urutan'     => (int) ($this->request->getPost('urutan') ?? 0),
            'status'     => $this->request->getPost('status') ?? 'aktif',
            'foto'       => $fotoName,
            'wali_kelas' => $this->request->getPost('wali_kelas'),
            'instagram'  => $this->request->getPost('instagram'),
            'facebook'   => $this->request->getPost('facebook'),
            'linkedin'   => $this->request->getPost('linkedin'),
            'urutan'     => (int) ($this->request->getPost('urutan') ?? 0),
            'status'     => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to('/sekolah/staff')
            ->with('success', 'Staff berhasil ditambahkan');
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $staff = $this->staffModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if (!$staff) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/staff/edit', [
            'title' => 'Edit Staff',
            'staff' => $staff
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

        $staff = $this->staffModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if (!$staff) {
            throw PageNotFoundException::forPageNotFound();
        }

        $uploadPath = FCPATH . 'uploads/staff/';
        $foto       = $this->request->getFile('foto');
        $fotoName   = $staff['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // 🧹 hapus foto lama
            if ($fotoName && is_file($uploadPath . $fotoName)) {
                unlink($uploadPath . $fotoName);
            }

            $fotoName = $foto->getRandomName();
            $foto->move($uploadPath, $fotoName);
        }

        $this->staffModel->update($id, [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'urutan'  => (int) ($this->request->getPost('urutan') ?? 0),
            'status'  => $this->request->getPost('status') ?? 'aktif',
            'foto'    => $fotoName,
            'wali_kelas' => $this->request->getPost('wali_kelas'),
            'instagram'  => $this->request->getPost('instagram'),
            'facebook'   => $this->request->getPost('facebook'),
            'linkedin'   => $this->request->getPost('linkedin'),
            'urutan'     => (int) ($this->request->getPost('urutan') ?? 0),
            'status'     => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to('/sekolah/staff')
            ->with('success', 'Staff berhasil diperbarui');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $staff = $this->staffModel
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->where('level', 'sekolah')
            ->first();

        if ($staff) {
            $path = FCPATH . 'uploads/staff/' . $staff['foto'];
            if (!empty($staff['foto']) && is_file($path)) {
                unlink($path);
            }

            $this->staffModel->delete($id);
        }

        return redirect()->back()
            ->with('success', 'Staff berhasil dihapus');
    }
}

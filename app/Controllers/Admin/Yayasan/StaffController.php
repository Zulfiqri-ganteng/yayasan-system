<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\CmsStaffModel;

class StaffController extends BaseController
{
    protected $staffModel;

    public function __construct()
    {
        $this->staffModel = new CmsStaffModel();
    }

    public function index()
    {
        return view('admin/yayasan/staff/index', [
            'title' => 'Staff Yayasan',
            'staff' => $this->staffModel->staffYayasan(),
        ]);
    }

    public function create()
    {
        return view('admin/yayasan/staff/create', [
            'title' => 'Tambah Staff Yayasan',
        ]);
    }

    public function store()
    {
        $fotoName = null;

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoName = 'staff_yayasan_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/staff', $fotoName);
        }

        $this->staffModel->insert([
            'level'   => 'yayasan',
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'urutan'  => $this->request->getPost('urutan'),
            'foto'    => $fotoName,
            'status'  => 'aktif',
        ]);

        return redirect()->to('admin/yayasan/staff')->with('success', 'Staff berhasil ditambahkan');
    }


    public function delete($id)
    {
        $staff = $this->staffModel->find($id);

        if ($staff && !empty($staff['foto'])) {
            $path = FCPATH . 'uploads/staff/' . $staff['foto'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->staffModel->delete($id);

        return redirect()->back()->with('success', 'Staff dihapus');
    }

    public function update($id)
    {
        $staff = $this->staffModel->find($id);

        if (!$staff) {
            return redirect()->back()->with('error', 'Data staff tidak ditemukan');
        }

        $data = [
            'nama'    => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'urutan'  => $this->request->getPost('urutan'),
            'status'  => $this->request->getPost('status') ?? $staff['status'],
        ];

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🔥 HAPUS FOTO LAMA
            if (!empty($staff['foto'])) {
                $oldPath = FCPATH . 'uploads/staff/' . $staff['foto'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // SIMPAN FOTO BARU
            $newName = 'staff_yayasan_' . $id . '_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/staff', $newName);

            $data['foto'] = $newName;
        }

        $this->staffModel->update($id, $data);

        return redirect()->to('admin/yayasan/staff')->with('success', 'Staff berhasil diperbarui');
    }
    public function edit($id)
    {
        $staff = $this->staffModel->find($id);

        if (!$staff) {
            return redirect()->back()->with('error', 'Data staff tidak ditemukan');
        }

        return view('admin/yayasan/staff/edit', [
            'title' => 'Edit Staff Yayasan',
            'staff' => $staff,
        ]);
    }
}

<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\CmsPengumumanModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PengumumanController extends BaseController
{
    protected CmsPengumumanModel $model;

    public function __construct()
    {
        $this->model = new CmsPengumumanModel();
    }

    /* ================= INDEX ================= */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        return view('admin/sekolah/pengumuman/index', [
            'title'      => 'Pengumuman Sekolah',
            'pengumuman' => $this->model->getBySekolah($sekolahId)
        ]);
    }

    /* ================= CREATE ================= */
    public function create()
    {
        return view('admin/sekolah/pengumuman/create');
    }

    /* ================= STORE ================= */
    public function store()
    {
        $sekolahId = session()->get('sekolah_id');

        $rules = [
            'judul' => 'required|min_length[3]',
            'isi'   => 'required',
            'file'  => 'permit_empty|mime_in[file,image/jpg,image/jpeg,image/png,image/webp,application/pdf]|max_size[file,4096]'
        ];

        if (!$this->validate($rules)) {
            return back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $uploadPath = FCPATH . 'uploads/pengumuman/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $fileName = null;
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move($uploadPath, $fileName);
        }

        $status = $this->request->getPost('status');

        $this->model->insert([
            'sekolah_id'      => $sekolahId,
            'judul'           => $this->request->getPost('judul'),
            'isi'             => $this->request->getPost('isi'),
            'file'            => $fileName,
            'status'          => $status,
            'tanggal_publish' => $status === 'publish' ? date('Y-m-d') : null,
        ]);

        return redirect()->to('/sekolah/pengumuman')
            ->with('success', 'Pengumuman berhasil disimpan');
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $pengumuman = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$pengumuman) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/sekolah/pengumuman/edit', compact('pengumuman'));
    }

    /* ================= UPDATE ================= */
    public function update($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $pengumuman = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$pengumuman) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'judul' => 'required|min_length[3]',
            'isi'   => 'required',
            'file'  => 'permit_empty|mime_in[file,image/jpg,image/jpeg,image/png,image/webp,application/pdf]|max_size[file,4096]'
        ];

        if (!$this->validate($rules)) {
            return back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $status = $this->request->getPost('status');

        $data = [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $status,
            // reset / set tanggal_publish dengan benar
            'tanggal_publish' => $status === 'publish'
                ? ($pengumuman['tanggal_publish'] ?? date('Y-m-d'))
                : null,
        ];

        $uploadPath = FCPATH . 'uploads/pengumuman/';
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // 🧹 hapus file lama
            if (!empty($pengumuman['file'])) {
                $old = $uploadPath . $pengumuman['file'];
                if (is_file($old)) {
                    unlink($old);
                }
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['file'] = $newName;
        }

        $this->model->update($id, $data);

        return redirect()->to('/sekolah/pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    /* ================= DELETE ================= */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $pengumuman = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if ($pengumuman) {
            if (!empty($pengumuman['file'])) {
                $path = FCPATH . 'uploads/pengumuman/' . $pengumuman['file'];
                if (is_file($path)) {
                    unlink($path);
                }
            }

            $this->model->delete($id);
        }

        return redirect()->back()
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}

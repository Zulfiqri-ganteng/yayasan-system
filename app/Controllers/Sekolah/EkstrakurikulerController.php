<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\EkstrakurikulerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EkstrakurikulerController extends BaseController
{
    protected EkstrakurikulerModel $model;

    public function __construct()
    {
        $this->model = new EkstrakurikulerModel();
    }

    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->model
            ->where('sekolah_id', $sekolahId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('sekolah/ekstrakurikuler/index', [
            'ekskul' => $data
        ]);
    }

    public function create()
    {
        return view('sekolah/ekstrakurikuler/create');
    }

    public function store()
    {
        $sekolahId = session()->get('sekolah_id');

        $rules = [
            'nama'      => 'required|min_length[3]',
            'pembina'   => 'required|min_length[3]',
            'jadwal'    => 'required',
            'tempat'    => 'required',
            'deskripsi' => 'required|min_length[10]',
            'status'    => 'required|in_list[draft,publish]',
            'gambar'    => 'uploaded[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        helper('text');

        $nama = $this->request->getPost('nama');
        $slug = url_title($nama, '-', true);

        // 🔒 Pastikan slug unik dalam sekolah yang sama
        $cekSlug = $this->model
            ->where('sekolah_id', $sekolahId)
            ->where('slug', $slug)
            ->countAllResults();

        if ($cekSlug > 0) {
            $slug .= '-' . time();
        }

        // ================= UPLOAD =================
        $uploadPath = FCPATH . 'uploads/ekstrakurikuler/' . $sekolahId . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file = $this->request->getFile('gambar');
        $fileName = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        // ================= INSERT =================
        $this->model->insert([
            'sekolah_id' => $sekolahId,
            'nama'       => esc($nama),
            'slug'       => $slug,
            'pembina'    => esc($this->request->getPost('pembina')),
            'jadwal'     => esc($this->request->getPost('jadwal')),
            'tempat'     => esc($this->request->getPost('tempat')),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'gambar'     => $fileName,
        ]);

        return redirect()->to('/sekolah/ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$data) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/ekstrakurikuler/edit', [
            'ekskul' => $data
        ]);
    }

    public function update($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $dataLama = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$dataLama) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nama'      => 'required|min_length[3]',
            'pembina'   => 'required|min_length[3]',
            'jadwal'    => 'required',
            'tempat'    => 'required',
            'deskripsi' => 'required|min_length[10]',
            'status'    => 'required|in_list[draft,publish]',
            'gambar'    => 'if_exist|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        helper('text');

        $namaBaru = $this->request->getPost('nama');
        $slug = $dataLama['slug']; // default pakai slug lama

        // 🔁 Kalau nama berubah → regenerate slug
        if ($namaBaru !== $dataLama['nama']) {

            $slugBaru = url_title($namaBaru, '-', true);

            // cek slug unik dalam sekolah yang sama
            $cekSlug = $this->model
                ->where('sekolah_id', $sekolahId)
                ->where('slug', $slugBaru)
                ->where('id !=', $id)
                ->countAllResults();

            if ($cekSlug > 0) {
                $slugBaru .= '-' . time();
            }

            $slug = $slugBaru;
        }

        $updateData = [
            'nama'       => esc($namaBaru),
            'slug'       => $slug,
            'pembina'    => esc($this->request->getPost('pembina')),
            'jadwal'     => esc($this->request->getPost('jadwal')),
            'tempat'     => esc($this->request->getPost('tempat')),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // ================= HANDLE GAMBAR =================
        $uploadPath = FCPATH . 'uploads/ekstrakurikuler/' . $sekolahId . '/';
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            // hapus gambar lama
            if (!empty($dataLama['gambar'])) {
                $oldPath = $uploadPath . $dataLama['gambar'];
                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $updateData['gambar'] = $newName;
        }

        $this->model->update($id, $updateData);

        return redirect()->to('/sekolah/ekstrakurikuler')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->model
            ->where('id', $id)
            ->where('sekolah_id', $sekolahId)
            ->first();

        if (!$data) {
            throw PageNotFoundException::forPageNotFound();
        }

        $uploadPath = FCPATH . 'uploads/ekstrakurikuler/' . $sekolahId . '/';

        if (!empty($data['gambar'])) {
            $path = $uploadPath . $data['gambar'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->model->delete($id);

        return redirect()->back()
            ->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}

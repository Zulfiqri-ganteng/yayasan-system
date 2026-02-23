<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FiturModel;

class FiturController extends BaseController
{
    protected $fiturModel;

    public function __construct()
    {
        $this->fiturModel = new FiturModel();
    }

    public function index()
    {
        return view('admin/fitur/index', [
            'title' => 'Master Fitur',
            'fitur' => $this->fiturModel
                ->orderBy('kategori', 'ASC')
                ->orderBy('nama', 'ASC')
                ->findAll()
        ]);
    }

    public function create()
    {
        return view('admin/fitur/create', [
            'title' => 'Tambah Fitur'
        ]);
    }

    public function store()
    {
        // ===============================
        // VALIDASI FORM (WAJIB)
        // ===============================
        $rules = [
            'kode' => [
                'rules'  => 'required|min_length[3]|max_length[50]|alpha_dash|is_unique[fitur.kode]',
                'errors' => [
                    'required'   => 'Kode fitur wajib diisi',
                    'alpha_dash' => 'Kode hanya boleh huruf kecil, angka, dan underscore',
                    'is_unique'  => 'Kode fitur sudah digunakan'
                ]
            ],
            'nama' => [
                'rules'  => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama fitur wajib diisi'
                ]
            ],
            'kategori' => [
                'rules'  => 'required|in_list[akademik,keuangan,absensi,cms,master]',
                'errors' => [
                    'in_list' => 'Kategori tidak valid'
                ]
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // ===============================
        // NORMALISASI KODE (ANTI ERROR)
        // ===============================
        $kode = strtolower($this->request->getPost('kode'));
        $kode = preg_replace('/[^a-z0-9_]/', '', $kode);

        // ===============================
        // BLOK KODE TERLARANG (ANTI CEMAR)
        // ===============================
        $blocked = [
            'tes',
            'test',
            'coba',
            'sample',
            'dummy'
        ];

        if (in_array($kode, $blocked)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode fitur tidak diperbolehkan');
        }

        // ===============================
        // SIMPAN KE DATABASE
        // ===============================
        $this->fiturModel->insert([
            'kode'     => $kode,
            'nama'     => trim($this->request->getPost('nama')),
            'kategori' => strtolower($this->request->getPost('kategori')),
        ]);

        return redirect()->to('/admin/fitur')
            ->with('success', 'Fitur berhasil ditambahkan');
    }


    public function edit($id)
    {
        return view('admin/fitur/edit', [
            'title' => 'Edit Fitur',
            'fitur' => $this->fiturModel->find($id)
        ]);
    }

    public function update($id)
    {
        $this->fiturModel->update($id, [
            'nama'     => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
        ]);

        return redirect()->to('/admin/fitur')
            ->with('success', 'Fitur berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->fiturModel->delete($id);

        return redirect()->back()
            ->with('success', 'Fitur berhasil dihapus dari sistem');
    }
}

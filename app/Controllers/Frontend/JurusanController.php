<?php

namespace App\Controllers\Frontend;

use App\Models\CmsJurusanModel;

class JurusanController extends FrontendBaseController
{
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new CmsJurusanModel();
    }

    // ===========================
    // LIST JURUSAN
    // ===========================
    public function index()
    {
        // 🔒 Harus sekolah
        if ($this->context['type'] !== 'sekolah') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 🔒 Harus SMK
        if ($this->context['jenjang'] !== 'smk') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $jurusan = $this->jurusanModel
            ->where('sekolah_id', $this->context['sekolah_id'])
            ->where('status', 'publish')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        return view('sekolah/program_unggulan/jurusan/index', [
            'jurusan' => $jurusan
        ]);
    }

    // ===========================
    // DETAIL JURUSAN
    // ===========================
    public function detail($slug)
    {
        if ($this->context['type'] !== 'sekolah') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->context['jenjang'] !== 'smk') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $jurusan = $this->jurusanModel
            ->where('slug', $slug)
            ->where('sekolah_id', $this->context['sekolah_id'])
            ->where('status', 'publish')
            ->first();

        if (!$jurusan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // sementara dummy
        $jumlahSiswa = rand(50, 150);

        return view('sekolah/program_unggulan/jurusan/detail', [
            'jurusan'     => $jurusan,
            'jumlahSiswa' => $jumlahSiswa
        ]);
    }
}

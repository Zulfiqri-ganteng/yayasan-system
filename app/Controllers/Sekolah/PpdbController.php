<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\PpdbModel;
use App\Models\Sekolah\PpdbPendaftarModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\ProfilSekolahModel;

class PpdbController extends BaseController
{
    protected $ppdbModel;
    protected $pendaftarModel;

    public function __construct()
    {
        $this->ppdbModel       = new PpdbModel();
        $this->pendaftarModel  = new PpdbPendaftarModel();
        $this->profilSekolahModel = new ProfilSekolahModel();
    }

    /* =====================================================
     * LIST PPDB
     * ===================================================== */
    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        return view('admin/sekolah/ppdb/index', [
            'title' => 'PPDB Sekolah',
            'ppdb'  => $this->ppdbModel
                ->where('sekolah_id', $sekolahId)
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ]);
    }

    /* =====================================================
     * CREATE
     * ===================================================== */
    public function create()
    {
        return view('admin/sekolah/ppdb/create', [
            'title' => 'Tambah PPDB'
        ]);
    }

    /* =====================================================
     * STORE
     * ===================================================== */
    public function store()
    {
        $sekolahId = session()->get('sekolah_id');

        $rules = [
            'judul'           => 'required',
            'tahun_ajaran'    => 'required',
            'tanggal_mulai'   => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'banner'          => 'max_size[banner,2048]|is_image[banner]'
        ];

        if (!$this->validate($rules)) {
            return back()->withInput()->with('error', $this->validator->getErrors());
        }

        /* ===============================
         * Batasi hanya 1 PPDB buka
         * =============================== */
        if ($this->request->getPost('status') === 'buka') {
            $this->ppdbModel
                ->where('sekolah_id', $sekolahId)
                ->set(['status' => 'tutup'])
                ->update();
        }

        /* ===============================
         * Upload Banner (Per Sekolah)
         * =============================== */
        $bannerName = null;
        $banner = $this->request->getFile('banner');

        if ($banner && $banner->isValid() && !$banner->hasMoved()) {

            $path = FCPATH . 'uploads/ppdb/' . $sekolahId;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $bannerName = $banner->getRandomName();
            $banner->move($path, $bannerName);
        }

        $this->ppdbModel->insert([
            'sekolah_id'      => $sekolahId,
            'judul'           => $this->request->getPost('judul'),
            'tahun_ajaran'    => $this->request->getPost('tahun_ajaran'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'banner'          => $bannerName,
            'status'          => $this->request->getPost('status')
        ]);

        return redirect()->to('/sekolah/ppdb')
            ->with('success', 'PPDB berhasil ditambahkan');
    }

    /* =====================================================
     * EDIT
     * ===================================================== */
    public function edit($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $ppdb = $this->ppdbModel->where([
            'id' => $id,
            'sekolah_id' => $sekolahId
        ])->first();

        if (!$ppdb) {
            return redirect()->to('/sekolah/ppdb');
        }

        return view('admin/sekolah/ppdb/edit', [
            'title' => 'Edit PPDB',
            'ppdb'  => $ppdb
        ]);
    }

    /* =====================================================
     * UPDATE
     * ===================================================== */
    public function update($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $ppdb = $this->ppdbModel->where([
            'id' => $id,
            'sekolah_id' => $sekolahId
        ])->first();

        if (!$ppdb) {
            return redirect()->to('/sekolah/ppdb');
        }

        /* ===============================
         * Batasi hanya 1 PPDB buka
         * =============================== */
        if ($this->request->getPost('status') === 'buka') {
            $this->ppdbModel
                ->where('sekolah_id', $sekolahId)
                ->where('id !=', $id)
                ->set(['status' => 'tutup'])
                ->update();
        }

        /* ===============================
         * Upload Banner Baru
         * =============================== */
        $bannerName = $ppdb['banner'];
        $banner     = $this->request->getFile('banner');

        if ($banner && $banner->isValid() && !$banner->hasMoved()) {

            $path = FCPATH . 'uploads/ppdb/' . $sekolahId . '/';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if (!empty($ppdb['banner']) && file_exists($path . $ppdb['banner'])) {
                unlink($path . $ppdb['banner']);
            }

            $bannerName = $banner->getRandomName();
            $banner->move($path, $bannerName);
        }

        $this->ppdbModel->update($id, [
            'judul'           => $this->request->getPost('judul'),
            'tahun_ajaran'    => $this->request->getPost('tahun_ajaran'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'banner'          => $bannerName,
            'status'          => $this->request->getPost('status')
        ]);

        return redirect()->to('/sekolah/ppdb')
            ->with('success', 'PPDB berhasil diperbarui');
    }

    /* =====================================================
     * DELETE
     * ===================================================== */
    public function delete($id)
    {
        $sekolahId = session()->get('sekolah_id');

        $ppdb = $this->ppdbModel->where([
            'id' => $id,
            'sekolah_id' => $sekolahId
        ])->first();

        if ($ppdb) {

            $path = FCPATH . 'uploads/ppdb/' . $sekolahId . '/';

            if (!empty($ppdb['banner']) && file_exists($path . $ppdb['banner'])) {
                unlink($path . $ppdb['banner']);
            }

            $this->ppdbModel->delete($id);
        }

        return redirect()->to('/sekolah/ppdb')
            ->with('success', 'PPDB berhasil dihapus');
    }

    /* =====================================================
     * LIHAT PENDAFTAR
     * ===================================================== */
    public function pendaftar()
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->pendaftarModel
            ->where('sekolah_id', $sekolahId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/sekolah/ppdb/pendaftar', [
            'title' => 'Data Pendaftar PPDB',
            'pendaftar' => $data
        ]);
    }

    /* =====================================================
     * UPDATE STATUS PENDAFTAR
     * ===================================================== */
    public function updateStatus($id, $status)
    {
        $sekolahId = session()->get('sekolah_id');

        $pendaftar = $this->pendaftarModel->where([
            'id' => $id,
            'sekolah_id' => $sekolahId
        ])->first();

        if ($pendaftar) {
            $this->pendaftarModel->update($id, [
                'status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
    public function printPendaftar()
    {
        $sekolahId = session()->get('sekolah_id');

        if (!$sekolahId) {
            return redirect()->back();
        }

        // Ambil profil sekolah
        $profilModel = new \App\Models\ProfilSekolahModel();
        $sekolah = $profilModel->where('sekolah_id', $sekolahId)->first();

        // Ambil semua pendaftar sekolah ini
        $pendaftar = $this->pendaftarModel
            ->where('sekolah_id', $sekolahId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/sekolah/ppdb/print', [
            'pendaftar' => $pendaftar,
            'sekolah'   => $sekolah
        ]);
    }

    public function exportPdf()
    {
        $sekolahId = session()->get('sekolah_id');

        if (!$sekolahId) {
            return redirect()->back();
        }

        // Ambil profil sekolah
        $profilModel = new \App\Models\ProfilSekolahModel();
        $sekolah = $profilModel->where('sekolah_id', $sekolahId)->first();

        if (!$sekolah) {
            return redirect()->back()->with('error', 'Profil sekolah tidak ditemukan.');
        }

        // Ambil pendaftar status diterima saja
        $pendaftar = $this->pendaftarModel
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'diterima')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        if (empty($pendaftar)) {
            return redirect()->back()->with('error', 'Tidak ada data diterima.');
        }

        /*
    |--------------------------------------------------------------------------
    | FIX LOGO PATH UNTUK DOMPDF
    |--------------------------------------------------------------------------
    */
        $logoPath = null;

        if (!empty($sekolah['logo'])) {
            $filePath = FCPATH . 'uploads/logo/' . $sekolah['logo'];

            if (file_exists($filePath)) {
                $type = pathinfo($filePath, PATHINFO_EXTENSION);
                $data = file_get_contents($filePath);
                $logoPath = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }

        $html = view('admin/sekolah/ppdb/pdf', [
            'sekolah'   => $sekolah,
            'pendaftar' => $pendaftar,
            'logoPath'  => $logoPath
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream(
            'laporan_ppdb_' . date('Ymd_His') . '.pdf',
            ['Attachment' => false]
        );
    }
}

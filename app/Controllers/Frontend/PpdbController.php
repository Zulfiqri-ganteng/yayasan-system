<?php

namespace App\Controllers\Frontend;

use App\Controllers\Frontend\FrontendBaseController;
use App\Models\Sekolah\PpdbModel;
use App\Models\Sekolah\PpdbPendaftarModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PpdbController extends FrontendBaseController
{
    protected $ppdbModel;
    protected $pendaftarModel;

    public function __construct()
    {
        $this->ppdbModel      = new PpdbModel();
        $this->pendaftarModel = new PpdbPendaftarModel();
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN INFO PPDB
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $type      = $this->context['type'];
        $sekolahId = (int) $this->context['sekolah_id'];

        if ($type === 'yayasan') {
            return view('frontend/ppdb/index', [
                'title'   => 'PPDB Online',
                'ppdb'    => null,
                'context' => $this->context,
                'type'    => $type
            ]);
        }

        if ($sekolahId <= 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        $ppdb = $this->ppdbModel
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'buka')
            ->orderBy('id', 'DESC')
            ->first();

        return view('frontend/ppdb/index', [
            'title'   => 'PPDB ' . ($this->context['sekolah']['nama_sekolah'] ?? ''),
            'ppdb'    => $ppdb,
            'context' => $this->context,
            'type'    => $type
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function form()
    {
        $sekolahId = (int) $this->context['sekolah_id'];

        if ($sekolahId <= 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        $ppdb = $this->ppdbModel
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'buka')
            ->first();

        if (!$ppdb) {
            return redirect()->to(current_url());
        }

        return view('frontend/ppdb/form', [
            'title'   => 'Form Pendaftaran',
            'ppdb'    => $ppdb,
            'context' => $this->context
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function submit()
    {
        $sekolahId = (int) $this->context['sekolah_id'];

        if ($sekolahId <= 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        $ppdbId = $this->request->getPost('ppdb_id');

        $ppdb = $this->ppdbModel
            ->where('id', $ppdbId)
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'buka')
            ->first();

        if (!$ppdb) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nama_lengkap'  => 'required|min_length[3]',
            'no_hp'         => 'required|min_length[10]',
            'tanggal_lahir' => 'permit_empty|valid_date[Y-m-d]',
            'email'         => 'permit_empty|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(current_url())
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $this->pendaftarModel->insert([
            'ppdb_id'       => $ppdbId,
            'sekolah_id'    => $sekolahId,
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'nisn'          => $this->request->getPost('nisn'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir') ?: null,
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'asal_sekolah'  => $this->request->getPost('asal_sekolah'),
            'status'        => 'pending'
        ]);

        return redirect()->to(current_url())
            ->with('success', 'Pendaftaran berhasil dikirim. Kami akan menghubungi Anda.');
    }
}

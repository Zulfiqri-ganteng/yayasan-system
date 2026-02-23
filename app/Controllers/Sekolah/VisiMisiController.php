<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Sekolah\VisiMisiSekolahModel;

class VisiMisiController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new VisiMisiSekolahModel();
    }

    public function index()
    {
        $sekolahId = session()->get('sekolah_id');

        $data = $this->model
            ->where('sekolah_id', $sekolahId)
            ->first();

        return view('sekolah/cms/visi_misi/index', [
            'data' => $data
        ]);
    }

    public function save()
    {
        $sekolahId = session()->get('sekolah_id');
        $existing  = $this->model->where('sekolah_id', $sekolahId)->first();

        $payload = [
            'sekolah_id' => $sekolahId,
            'visi'       => $this->request->getPost('visi'),
            'misi'       => $this->request->getPost('misi'),
            'status'     => 'publish'
        ];

        if ($existing) {
            $this->model->update($existing['id'], $payload);
        } else {
            $this->model->insert($payload);
        }

        return redirect()->back()->with('success', 'Visi & Misi Sekolah berhasil disimpan');
    }
}

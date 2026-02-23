<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\CmsVisiMisiModel;

class VisiMisiController extends BaseController
{
    public function index()
    {
        $sekolahId = 1;

        $model = new CmsVisiMisiModel();
        $data = $model->where('sekolah_id', $sekolahId)->first();

        return view('admin/yayasan/visi_misi/index', [
            'title' => 'CMS Visi & Misi',
            'data'  => $data,
        ]);
    }

    public function save()
    {
        $sekolahId = 0; // For Yayasan, set sekolah_id to 0
        $model = new CmsVisiMisiModel();

        $payload = [
            'sekolah_id' => $sekolahId,
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),
        ];

        $existing = $model->where('sekolah_id', $sekolahId)->first();

        if ($existing) {
            $model->update($existing['id'], $payload);
        } else {
            $model->insert($payload);
        }

        return redirect()->back()->with('success', 'Visi & Misi berhasil disimpan');
    }
}

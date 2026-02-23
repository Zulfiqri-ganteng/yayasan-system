<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\Yayasan\ProfilYayasanModel;

class ProfilController extends BaseController
{
    protected $profilModel;

    public function __construct()
    {
        $this->profilModel = new ProfilYayasanModel();
    }

    public function index()
    {
        $profil = $this->profilModel->first();

        return view('admin/yayasan/profil/index', [
            'title'  => 'Profil Yayasan',
            'profil' => $profil
        ]);
    }

    public function save()
    {
        $data = $this->request->getPost();

        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid()) {
            $newName = $logo->getRandomName();
            $logo->move('uploads/yayasan', $newName);
            $data['logo'] = $newName;
        }

        $profil = $this->profilModel->first();

        if ($profil) {
            $this->profilModel->update($profil['id'], $data);
        } else {
            $this->profilModel->insert($data);
        }

        return redirect()->to(base_url('admin/yayasan/profil'))
            ->with('success', 'Profil Yayasan berhasil disimpan');
    }
}

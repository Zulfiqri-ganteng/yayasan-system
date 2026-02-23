<?php

namespace App\Controllers\Admin\Yayasan;

use App\Controllers\BaseController;
use App\Models\Yayasan\SejarahYayasanModel;

class SejarahController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SejarahYayasanModel();
    }

    public function index()
    {
        return view('admin/yayasan/sejarah/index', [
            'title' => 'Sejarah Yayasan',
            'data'  => $this->model
                ->orderBy('urutan', 'ASC')
                ->findAll()
        ]);
    }

    public function save()
    {
        $this->model->save([
            'id'        => $this->request->getPost('id'),
            'tahun'     => $this->request->getPost('tahun'),
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan'    => $this->request->getPost('urutan'),
            'status'    => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->back()->with('success', 'Sejarah berhasil disimpan');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}

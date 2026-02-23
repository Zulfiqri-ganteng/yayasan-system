<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class ProfilController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tentang Kami | Yayasan Persada Plus Galajuara'
        ];

        return view('frontend/profil/index', $data);
    }
}

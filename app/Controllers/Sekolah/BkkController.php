<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;

class BkkController extends BaseController
{
    public function index()
    {
        return view('admin/sekolah/bkk/coming_soon', [
            'title' => 'BKK'
        ]);
    }
}

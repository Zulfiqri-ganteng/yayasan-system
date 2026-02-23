<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;

class PklController extends BaseController
{
    public function index()
    {
        return view('admin/sekolah/pkl/coming_soon', [
            'title' => 'PKL'
        ]);
    }
}

<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;

class ComingSoonController extends BaseController
{
    public function index($title = 'Fitur')
    {
        return view('admin/sekolah/coming_soon', [
            'title' => $title
        ]);
    }
}

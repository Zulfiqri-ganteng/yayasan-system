<?php

namespace App\Controllers\Frontend;

use CodeIgniter\Exceptions\PageNotFoundException;

class KesiswaanController extends FrontendBaseController
{
    public function index()
    {
        // 🔒 Harus sekolah
        if ($this->context['type'] !== 'sekolah') {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('frontend/kesiswaan/index');
    }
}

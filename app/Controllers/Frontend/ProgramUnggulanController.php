<?php

namespace App\Controllers\Frontend;

class ProgramUnggulanController extends FrontendBaseController
{
    public function index()
    {
        if ($this->context['type'] !== 'sekolah' || $this->context['jenjang'] !== 'smk') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('sekolah/program_unggulan/index');
    }
}
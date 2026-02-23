<?php
namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('sekolah/dashboard', [
            'title' => 'Dashboard Admin Sekolah'
        ]);
    }
}

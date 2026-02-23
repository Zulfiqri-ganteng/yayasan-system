<?php

namespace App\Controllers\Yayasan;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'breadcrumb' => ['Dashboard']
        ]);
    }
}

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FeatureFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Harus login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Hanya admin sekolah
        if (session()->get('role') !== 'admin_sekolah') {
            return redirect()->to('/login');
        }

        // Fitur wajib disebutkan (misal: bkk)
        $fitur = $arguments[0] ?? null;
        if (!$fitur) {
            return redirect()->back();
        }

        // Pakai helper yang sudah kita punya
        if (!function_exists('school_has_feature')) {
            helper('feature');
        }

        if (!school_has_feature($fitur)) {
            // Akses ditolak
            return redirect()->to('/sekolah/dashboard')
                ->with('error', 'Fitur tidak aktif untuk sekolah ini');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu
    }
}

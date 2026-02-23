<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SekolahModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ===============================
        // 1. BELUM LOGIN
        // ===============================
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        // ===============================
        // 🔐 IDLE AUTO LOGOUT (1 JAM)
        // ===============================
        $timeout = 3600; // 1 jam

        $lastActivity = session()->get('last_activity');

        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            session()->destroy();
            return redirect()->to('/login')
                ->with('error', 'Session habis karena tidak aktif selama 1 jam.');
        }

        // Update waktu aktivitas
        session()->set('last_activity', time());
        // ===============================
        // 2. KHUSUS ADMIN SEKOLAH
        // ===============================
        if (session()->get('role') === 'admin_sekolah') {

            $sekolahId = session()->get('sekolah_id');

            // Jika tidak punya sekolah_id → tidak valid
            if (!$sekolahId) {

                session()->setFlashdata(
                    'error',
                    'Akun Anda tidak terhubung dengan sekolah yang valid.'
                );

                session()->remove([
                    'isLoggedIn',
                    'user_id',
                    'role',
                    'sekolah_id',
                ]);

                return redirect()->to('/login');
            }

            // Ambil data sekolah
            $sekolahModel = new SekolahModel();
            $sekolah = $sekolahModel->find($sekolahId);

            // ===============================
            // 3. SEKOLAH NONAKTIF / TIDAK ADA
            // ===============================
            if (!$sekolah || (int) $sekolah['status'] !== 1) {

                session()->setFlashdata(
                    'error',
                    'Akun sekolah Anda telah dinonaktifkan oleh Yayasan.'
                );

                // Hapus session login SAJA (bukan destroy total)
                session()->remove([
                    'isLoggedIn',
                    'user_id',
                    'role',
                    'sekolah_id',
                ]);

                return redirect()->to('/login');
            }
        }

        // ===============================
        // 4. LOLOS → LANJUTKAN REQUEST
        // ===============================
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}

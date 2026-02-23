<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class SessionSecurity implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('user_id')) {
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->find(session('user_id'));

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        if (
            session('password_changed_at') &&
            $user['password_changed_at'] != session('password_changed_at')
        ) {
            session()->destroy();
            return redirect()->to('/login')
                ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AuditLogModel;

class PengaturanController extends BaseController
{
    protected $userModel;
    protected $audit;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->audit = new AuditLogModel();
    }

    public function index()
    {
        return view('admin/pengaturan/index');
    }

    public function gantiPassword()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        if (!$user || !password_verify($this->request->getPost('password_lama'), $user['password'])) {
            return $this->fail('Password lama salah');
        }

        if ($this->request->getPost('password_baru') !== $this->request->getPost('password_konfirmasi')) {
            return $this->fail('Konfirmasi password tidak cocok');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)
        ]);

        // 🧾 AUDIT LOG
        $this->audit->insert([
            'user_id' => $userId,
            'aksi'    => 'Ganti Password',
            'ip'      => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 🚪 FORCE LOGOUT ALL
        session()->destroy();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Password berhasil diubah. Mengamankan sesi...'
        ]);
    }
}

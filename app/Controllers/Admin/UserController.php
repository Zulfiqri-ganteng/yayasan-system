<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SekolahModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $sekolahModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->sekolahModel = new SekolahModel();
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $users = $this->userModel
            ->select('users.*, sekolah.nama_sekolah, sekolah.jenjang')
            ->join('sekolah', 'sekolah.id = users.sekolah_id', 'left')
            ->where('users.role', 'admin_sekolah')
            ->orderBy('users.id', 'ASC')
            ->findAll();

        return view('admin/users/index', [
            'title' => 'Admin Sekolah',
            'users' => $users
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('admin/users/create', [
            'title'   => 'Tambah Admin Sekolah',
            'sekolah' => $this->sekolahModel
                ->where('status', 1)
                ->where('jenjang !=', 'yayasan')
                ->findAll()
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $rules = [
            'sekolah_id' => 'required',
            'username'   => 'required|min_length[4]|is_unique[users.username]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->userModel->insert([
            'sekolah_id' => $this->request->getPost('sekolah_id'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => 'admin_sekolah',
            'status'     => 1
        ]);

        return redirect()->to('/admin/users')
            ->with('success', 'Admin sekolah berhasil dibuat');
    }

    // =========================
    // RESET PASSWORD ADMIN SEKOLAH
    // =========================
    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'User tidak ditemukan');
        }

        if ($user['role'] !== 'admin_sekolah') {
            return redirect()->back()
                ->with('error', 'Reset password hanya untuk admin sekolah');
        }

        $defaultPassword = $user['username'];

        $this->userModel->update($id, [
            'password' => password_hash($defaultPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()
            ->with(
                'success',
                'Password berhasil direset. Password sekarang: ' . $user['username']
            );
    }

    // =========================
    // EDIT ADMIN SEKOLAH
    // =========================
    public function edit($id)
    {
        $user = $this->userModel
            ->select('users.*, sekolah.nama_sekolah')
            ->join('sekolah', 'sekolah.id = users.sekolah_id', 'left')
            ->where('users.id', $id)
            ->where('users.role', 'admin_sekolah')
            ->first();

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'Admin sekolah tidak ditemukan');
        }

        return view('admin/users/edit', [
            'title'   => 'Edit Admin Sekolah',
            'user'    => $user,
            'sekolah' => $this->sekolahModel
                ->where('status', 1)
                ->where('jenjang !=', 'yayasan')
                ->findAll()
        ]);
    }

    // =========================
    // UPDATE ADMIN SEKOLAH
    // =========================
    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'Admin sekolah tidak ditemukan');
        }

        if ($user['role'] !== 'admin_sekolah') {
            return redirect()->to('/admin/users')
                ->with('error', 'Akses update tidak diizinkan');
        }

        $rules = [
            'sekolah_id' => 'required',
            'username'   => "required|min_length[4]|is_unique[users.username,id,{$id}]",
            'email'      => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->userModel->update($id, [
            'sekolah_id' => $this->request->getPost('sekolah_id'),
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'status'     => (int) $this->request->getPost('status')
        ]);

        return redirect()->to('/admin/users')
            ->with('success', 'Data admin sekolah berhasil diperbarui');
    }

    // =========================
    // DELETE ADMIN SEKOLAH
    // =========================
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Admin sekolah tidak ditemukan');
        }

        if ($user['role'] !== 'admin_sekolah') {
            return redirect()->back()
                ->with('error', 'Hanya admin sekolah yang bisa dihapus');
        }

        if (session('user_id') == $id) {
            return redirect()->back()
                ->with('error', 'Anda tidak bisa menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')
            ->with('success', 'Admin sekolah berhasil dihapus');
    }
}

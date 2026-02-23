<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PasswordResetModel;

class ForgotPasswordController extends BaseController
{
    protected $userModel;
    protected $resetModel;

    public function __construct()
    {
        $this->userModel  = new UserModel();
        $this->resetModel = new PasswordResetModel();
    }

    // =====================================================
    // FORM FORGOT PASSWORD
    // =====================================================
    public function index()
    {
        return view('auth/forgot_password');
    }

    // =====================================================
    // SEND RESET LINK
    // =====================================================
    public function send()
    {
        $email = trim($this->request->getPost('email'));

        if (!$email) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Format email tidak valid.');
        }

        $user = $this->userModel
            ->where('email', $email)
            ->where('status', 1)
            ->first();

        // Jangan bocorkan apakah email terdaftar
        if (!$user) {
            return redirect()->back()
                ->with('success', 'Jika email terdaftar, link reset telah dikirim.');
        }

        // =====================================================
        // GENERATE TOKEN
        // =====================================================
        $token      = bin2hex(random_bytes(32));
        $tokenHash  = hash('sha256', $token);
        $expiresAt  = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Invalidate token lama
        $this->resetModel
            ->where('user_id', $user['id'])
            ->set(['used' => 1])
            ->update();

        // Simpan token baru
        $this->resetModel->insert([
            'user_id'    => $user['id'],
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
            'used'       => 0
        ]);

        // =====================================================
        // SEND EMAIL
        // =====================================================
        $resetLink = base_url('reset-password?token=' . $token);

        $emailService = service('email');

        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - Sistem Yayasan');
        $emailService->setMailType('html'); // WAJIB untuk HTML

        // Header tambahan anti-spam
        $emailService->setHeader('X-Mailer', 'Sistem Akademik Sekolah');
        $emailService->setHeader('Reply-To', 'noreply@zulfiqri.com');
        $emailService->setHeader('X-Priority', '3');

        $emailService->setMessage("
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Reset Password</title>
</head>
<body style='margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;'>

<table width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td align='center'>

<table width='600' cellpadding='0' cellspacing='0' 
style='background:#ffffff;margin:40px 0;border-radius:8px;overflow:hidden;
box-shadow:0 4px 10px rgba(0,0,0,0.05);'>

<tr>
<td style='background:#4b49ac;padding:30px;text-align:center;color:#ffffff;'>
<h2 style='margin:0;'>Reset Password</h2>
</td>
</tr>

<tr>
<td style='padding:30px;color:#333;'>

<p>Halo,</p>

<p>Kami menerima permintaan untuk reset password akun Anda.</p>

<p style='text-align:center;margin:30px 0;'>
<a href='{$resetLink}' 
style='background:#4b49ac;color:#ffffff;padding:12px 25px;
text-decoration:none;border-radius:5px;display:inline-block;'>
Reset Password
</a>
</p>

<p>Link ini berlaku selama <strong>15 menit</strong>.</p>

<p>Jika Anda tidak merasa meminta reset password, abaikan email ini.</p>

<hr style='margin:30px 0;border:none;border-top:1px solid #eee;'>

<p style='font-size:12px;color:#999;'>
© " . date('Y') . " Sistem Informasi Akademik Sekolah
</p>

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
");

        $emailService->send();

        return redirect()->back()
            ->with('success', 'Jika email terdaftar, link reset telah dikirim.');
    }

    // =====================================================
    // FORM RESET PASSWORD
    // =====================================================
    public function resetForm()
    {
        $token = $this->request->getGet('token');

        if (!$token) {
            return redirect()->to('/login');
        }

        return view('auth/reset_password', [
            'token' => $token
        ]);
    }

    // =====================================================
    // PROCESS RESET PASSWORD
    // =====================================================
    public function processReset()
    {
        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('password_confirm');

        if (!$token || !$password || !$confirm) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak lengkap.');
        }

        if ($password !== $confirm) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfirmasi password tidak cocok.');
        }

        // =====================
        // VALIDASI PASSWORD KUAT
        // =====================
        $strongPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        if (!preg_match($strongPattern, $password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.');
        }


        $tokenHash = hash('sha256', $token);

        $reset = $this->resetModel
            ->where('token_hash', $tokenHash)
            ->where('used', 0)
            ->first();

        if (!$reset) {
            return redirect()->to('/login')
                ->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        if (strtotime($reset['expires_at']) < time()) {
            return redirect()->to('/login')
                ->with('error', 'Token sudah kadaluarsa.');
        }

        // Update password
        $this->userModel->update($reset['user_id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_changed_at' => date('Y-m-d H:i:s')
        ]);


        // Mark token used
        $this->resetModel->update($reset['id'], [
            'used' => 1
        ]);

        return redirect()->to('/login')
            ->with('success', 'Password berhasil diperbarui. Silakan login.');
    }
}

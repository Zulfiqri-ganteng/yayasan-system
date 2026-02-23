<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoginAttemptModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login');
    }

    public function process()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $ip       = $this->request->getIPAddress();

        $attemptModel = new LoginAttemptModel();

        // ===============================
        // 🔒 CEK LOCK LOGIN
        // ===============================
        $attempt = $attemptModel
            ->where('username', $username)
            ->where('ip_address', $ip)
            ->first();

        if ($attempt && $attempt['locked_until'] && strtotime($attempt['locked_until']) > time()) {
            return redirect()->back()
                ->with('error', 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        // ===============================
        // ❌ USER TIDAK ADA ATAU PASSWORD SALAH
        // ===============================
        if (!$user || !password_verify($password, $user['password'])) {

            if ($attempt) {
                $newAttempts = $attempt['attempts'] + 1;

                $data = [
                    'attempts'     => $newAttempts,
                    'last_attempt' => date('Y-m-d H:i:s'),
                ];

                if ($newAttempts >= 5) {
                    $data['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                }

                $attemptModel->update($attempt['id'], $data);
            } else {
                $attemptModel->insert([
                    'username'     => $username,
                    'ip_address'   => $ip,
                    'attempts'     => 1,
                    'last_attempt' => date('Y-m-d H:i:s'),
                ]);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password salah');
        }

        // ===============================
        // 🔒 CEK STATUS USER AKTIF
        // ===============================
        if ((int) $user['status'] !== 1) {
            return redirect()->back()
                ->with('error', 'Akun Anda dinonaktifkan.');
        }

        // ===============================
        // 🔒 VALIDASI ADMIN SEKOLAH
        // ===============================
        $jenjang = null;

        if ($user['role'] === 'admin_sekolah') {

            if (empty($user['sekolah_id'])) {
                return redirect()->back()
                    ->with('error', 'Akun admin sekolah belum terhubung.');
            }

            $sekolahModel = new \App\Models\SekolahModel();
            $sekolah = $sekolahModel->find($user['sekolah_id']);

            if (!$sekolah || (int)$sekolah['status'] !== 1) {
                return redirect()->back()
                    ->with('error', 'Sekolah Anda sedang dinonaktifkan.');
            }

            $jenjang = $sekolah['jenjang'];
        }

        // ===============================
        // ✅ LOGIN BERHASIL
        // ===============================
        // ===============================
        // 🔐 CEK DEVICE (OTP jika browser baru)
        // ===============================

        $otpEnabled = env('app.otpDeviceEnabled', true); // default true

        $cookieDevice = $_COOKIE['device_token'] ?? null;

        // Jika OTP diaktifkan
        if ($otpEnabled && (empty($user['device_token']) || $cookieDevice !== $user['device_token'])) {


            $code = random_int(100000, 999999);

            // 🔒 Hapus OTP lama dulu
            db_connect()->table('login_verifications')
                ->where('user_id', $user['id'])
                ->delete();

            db_connect()->table('login_verifications')->insert([
                'user_id'    => $user['id'],
                'code'       => password_hash($code, PASSWORD_DEFAULT),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            // Kirim email OTP
            $this->sendOTPEmail($user['email'], $code);

            session()->set('otp_user_id', $user['id']);

            return redirect()->to('/verify-login');
        }

        // Reset login attempts
        $attemptModel->where('username', $username)
            ->where('ip_address', $ip)
            ->delete();

        // Regenerate session (anti session fixation)
        session()->regenerate(true);

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'role'       => $user['role'],
            'sekolah_id' => $user['sekolah_id'] ?? null,
            'jenjang'    => $jenjang,
            'password_changed_at' => $user['password_changed_at'] ?? null,
        ]);


        return $this->redirectByRole($user['role']);
    }

    private function redirectByRole(string $role)
    {
        switch ($role) {
            case 'superadmin':
                return redirect()->to('/admin/dashboard');

            case 'admin_sekolah':
                return redirect()->to('/sekolah/dashboard');

            default:
                session()->destroy();
                return redirect()->to('/login')
                    ->with('error', 'Role tidak dikenali');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    private function sendOTPEmail($email, $code)
    {
        $emailService = \Config\Services::email();

        $emailService->setMailType('html');
        $emailService->setTo($email);
        $emailService->setSubject('🔐 Verifikasi Login Perangkat Baru');

        // ===============================
        // 🔍 Ambil IP Real (Support Proxy)
        // ===============================
        $ipAddress =
            $this->request->getServer('HTTP_X_FORWARDED_FOR')
            ?? $this->request->getServer('HTTP_CLIENT_IP')
            ?? $this->request->getIPAddress();

        // ===============================
        // 🌐 Ambil Browser & OS
        // ===============================
        $agent = $this->request->getUserAgent();
        $browser = $agent->getBrowser() . ' ' . $agent->getVersion();
        $platform = $agent->getPlatform();

        // ===============================
        // 🌍 Ambil Lokasi dari IP
        // ===============================
        $location = 'Tidak diketahui';

        if ($ipAddress !== '127.0.0.1' && $ipAddress !== '::1') {
            $response = @file_get_contents("http://ip-api.com/json/{$ipAddress}");
            if ($response) {
                $data = json_decode($response);
                if ($data && $data->status === 'success') {
                    $location = $data->city . ', ' . $data->country;
                }
            }
        }

        // ===============================
        // 🕒 Waktu Login (WIB)
        // ===============================
        date_default_timezone_set('Asia/Jakarta');
        $loginTime = date('d M Y H:i') . ' WIB';
        $year = date('Y');

        $message = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Verifikasi Login</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="padding:40px 0;">
<table width="500" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 8px 20px rgba(0,0,0,0.05);">
    
<tr>
<td style="background:#0d6efd;padding:25px;text-align:center;color:#ffffff;">
<h2 style="margin:0;">Sistem Informasi Akademik</h2>
<p style="margin:5px 0 0;font-size:14px;">Verifikasi Perangkat Baru</p>
</td>
</tr>

<tr>
<td style="padding:35px;text-align:center;">
<p style="font-size:16px;color:#333;">
Kami mendeteksi login dari perangkat baru.
</p>

<p style="margin:20px 0 10px;font-size:14px;color:#666;">
Gunakan kode berikut untuk melanjutkan login:
</p>

<div style="font-size:36px;font-weight:bold;letter-spacing:8px;color:#0d6efd;margin:25px 0;">
' . $code . '
</div>

<p style="font-size:13px;color:#888;">
Berlaku selama 10 menit.
</p>

<div style="margin-top:25px;padding:15px;background:#f8f9fa;border-radius:6px;font-size:12px;color:#666;text-align:left;">
<strong>Detail Login:</strong><br><br>
IP Address: ' . $ipAddress . '<br>
Browser: ' . $browser . '<br>
OS: ' . $platform . '<br>
Location: ' . $location . '<br>
Login Time: ' . $loginTime . '
</div>

<hr style="border:none;border-top:1px solid #eee;margin:30px 0;">

<p style="font-size:12px;color:#999;margin-bottom:10px;">
Jika Anda tidak melakukan login atau menemukan aktivitas mencurigakan,
silakan hubungi kami melalui email resmi:
</p>

<p style="font-size:12px;">
<a href="mailto:zulfiqri.250.guru.smk.belajar.id" 
   style="color:#0d6efd;text-decoration:none;font-weight:bold;">
zulfiqri.250.guru.smk.belajar.id
</a>
</p>

</td>
</tr>

<tr>
<td style="background:#f1f3f5;padding:15px;text-align:center;font-size:12px;color:#777;">
&copy; ' . $year . ' Sistem Informasi Akademik Sekolah<br><br>
<span style="font-size:11px;color:#999;">
My Creative by 
<a href="https://instagram.com/zufieee" 
   target="_blank"
   style="color:#E1306C;text-decoration:none;font-weight:bold;">
Zulfiqri, S.Kom
</a>
</span>
</td>
</tr>

</table>
</td>
</tr>
</table>
</body>
</html>
';

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
        }
    }

    public function verifyLogin()
    {
        if (!session()->get('otp_user_id')) {
            return redirect()->to('/login');
        }

        return view('auth/verify_login');
    }
    public function processVerifyLogin()
    {
        $userId = session()->get('otp_user_id');
        $inputCode = trim($this->request->getPost('code'));

        if (!$userId || !$inputCode) {
            return redirect()->to('/login');
        }

        // 🔒 Limit percobaan OTP (max 5x)
        $otpAttempts = session()->get('otp_attempts') ?? 0;

        if ($otpAttempts >= 5) {
            session()->destroy();
            return redirect()->to('/login')
                ->with('error', 'Terlalu banyak percobaan OTP. Silakan login ulang.');
        }

        $otp = db_connect()->table('login_verifications')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if (
            !$otp ||
            !password_verify($inputCode, $otp->code) ||
            strtotime($otp->expires_at) < time()
        ) {
            session()->set('otp_attempts', $otpAttempts + 1);
            usleep(500000);

            return redirect()->back()
                ->with('error', 'Kode tidak valid atau sudah kadaluarsa.');
        }

        // ✅ OTP valid
        session()->remove('otp_attempts');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        // 🔥 1️⃣ Hapus semua OTP user (clean table)
        db_connect()->table('login_verifications')
            ->where('user_id', $userId)
            ->delete();

        // 🔐 2️⃣ Generate & simpan device token baru
        $deviceToken = bin2hex(random_bytes(32));

        $userModel->update($userId, [
            'device_token' => $deviceToken
        ]);

        // 🍪 3️⃣ Set cookie device (setelah DB update sukses)
        setcookie(
            'device_token',
            $deviceToken,
            [
                'expires'  => time() + (86400 * 30),
                'path'     => '/',
                'secure'   => service('request')->isSecure(),
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );

        // 🛡 4️⃣ Bersihkan session OTP
        session()->remove('otp_user_id');

        // 🔄 5️⃣ Regenerate session (anti fixation)
        session()->regenerate(true);

        // ✅ 6️⃣ Set session login
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'role'       => $user['role'],
            'sekolah_id' => $user['sekolah_id'] ?? null,
        ]);

        return $this->redirectByRole($user['role']);
    }
    public function resendCode()
    {
        // 🔐 Pastikan user masih dalam proses OTP
        $userId = session()->get('otp_user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        // 🔒 Rate limit resend (minimal 60 detik)
        $lastResend = session()->get('last_resend_time');

        if ($lastResend && (time() - $lastResend) < 60) {
            return redirect()->back()
                ->with('error', 'Tunggu 60 detik sebelum kirim ulang.');
        }

        // Simpan waktu resend terbaru
        session()->set('last_resend_time', time());

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        // 🔢 Generate OTP baru
        $code = random_int(100000, 999999);

        // 🔒 Hapus semua OTP lama user ini
        db_connect()->table('login_verifications')
            ->where('user_id', $userId)
            ->delete();

        // 💾 Simpan OTP baru (hash + expire 10 menit)
        db_connect()->table('login_verifications')->insert([
            'user_id'    => $userId,
            'code'       => password_hash($code, PASSWORD_DEFAULT),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
            'created_at' => date('Y-m-d H:i:s'),
            'used_at'    => null
        ]);

        // 📧 Kirim email
        $this->sendOTPEmail($user['email'], $code);

        // 🔁 Reset counter percobaan OTP
        session()->remove('otp_attempts');

        return redirect()->back()
            ->with('success', 'Kode baru telah dikirim.');
    }
}

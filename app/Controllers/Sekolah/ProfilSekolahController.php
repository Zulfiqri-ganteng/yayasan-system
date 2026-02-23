<?php

namespace App\Controllers\Sekolah;
use App\Models\UserModel;
use App\Controllers\BaseController;
use App\Models\ProfilSekolahModel;

class ProfilSekolahController extends BaseController
{
    protected $profilModel;

    public function __construct()
    {
        $this->profilModel = new ProfilSekolahModel();
        $this->userModel   = new UserModel();
    }

    public function index()
    {
        // Proteksi session
        if (!session()->has('sekolah_id')) {
            return redirect()->to('/logout');
        }

        $sekolahId = session('sekolah_id');

        $profil = $this->profilModel
            ->where('sekolah_id', $sekolahId)
            ->first();

        return view('sekolah/profil/index', [
            'title'  => 'Profil Sekolah',
            'profil' => $profil
        ]);
    }

    public function simpan()
    {
        // Proteksi session
        if (!session()->has('sekolah_id')) {
            return redirect()->to('/logout');
        }

        // VALIDASI DASAR
        $rules = [
            'nama_sekolah' => 'required|min_length[5]',
            'logo'         => 'permit_empty|is_image[logo]|max_size[logo,2048]|mime_in[logo,image/png,image/jpg,image/jpeg]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama sekolah wajib diisi & logo harus gambar (max 2MB)');
        }

        $sekolahId = session('sekolah_id');

        // DATA FORM
        $data = [
            'sekolah_id'     => $sekolahId,
            'nama_sekolah'   => $this->request->getPost('nama_sekolah', FILTER_SANITIZE_SPECIAL_CHARS),
            'google_maps'    => $this->request->getPost('google_maps', FILTER_SANITIZE_SPECIAL_CHARS),
            'npsn'           => $this->request->getPost('npsn', FILTER_SANITIZE_SPECIAL_CHARS),
            'alamat'         => $this->request->getPost('alamat', FILTER_SANITIZE_SPECIAL_CHARS),
            'kepala_sekolah' => $this->request->getPost('kepala_sekolah', FILTER_SANITIZE_SPECIAL_CHARS),
            'nip_kepala'     => $this->request->getPost('nip_kepala', FILTER_SANITIZE_SPECIAL_CHARS),
            'desa'       => $this->request->getPost('desa', FILTER_SANITIZE_SPECIAL_CHARS),
            'kecamatan'  => $this->request->getPost('kecamatan', FILTER_SANITIZE_SPECIAL_CHARS),
            'kabupaten'  => $this->request->getPost('kabupaten', FILTER_SANITIZE_SPECIAL_CHARS),
            'provinsi'   => $this->request->getPost('provinsi', FILTER_SANITIZE_SPECIAL_CHARS),
            'kode_pos'   => $this->request->getPost('kode_pos', FILTER_SANITIZE_SPECIAL_CHARS),
            'email'      => $this->request->getPost('email', FILTER_SANITIZE_EMAIL),
            'no_telp'    => $this->request->getPost('no_telp', FILTER_SANITIZE_SPECIAL_CHARS),
            'website'    => $this->request->getPost('website', FILTER_SANITIZE_SPECIAL_CHARS),

        ];

        // CEK DATA SEBELUMNYA
        $profilLama = $this->profilModel
            ->where('sekolah_id', $sekolahId)
            ->first();

        /**
         * ===============================
         * UPLOAD LOGO SEKOLAH
         * ===============================
         */
        $file = $this->request->getFile('logo');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $newName = 'logo_sekolah_' . $sekolahId . '.' . $file->getExtension();

            // Hapus logo lama jika ada
            if (!empty($profilLama['logo']) && file_exists('uploads/logo/' . $profilLama['logo'])) {
                unlink('uploads/logo/' . $profilLama['logo']);
            }

            $file->move('uploads/logo', $newName);
            $data['logo'] = $newName;
        }

        /**
         * ===============================
         * INSERT / UPDATE
         * ===============================
         */
        if ($profilLama) {
            $this->profilModel->update($profilLama['id'], $data);
        } else {
            $this->profilModel->insert($data);
        }

        return redirect()->back()->with('success', 'Profil sekolah berhasil disimpan');
    }
    public function gantiPassword()
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->back()->with('error', 'Sesi login tidak valid');
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasi   = $this->request->getPost('password_konfirmasi');

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()
                ->with('error', 'Konfirmasi password tidak sesuai');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user || !password_verify($passwordLama, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Password lama salah');
        }

        $userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui');
    }
}

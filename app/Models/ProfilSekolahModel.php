<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilSekolahModel extends Model
{
    protected $table = 'profil_sekolah';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'nama_sekolah',
        'npsn',
        'alamat',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'email',
        'no_telp',
        'website',
        'kepala_sekolah',
        'google_maps',
        'nip_kepala',
        'logo'
    ];

    protected $useTimestamps = true;
}

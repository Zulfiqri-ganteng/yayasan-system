<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class PpdbPendaftarModel extends Model
{
    protected $table = 'ppdb_pendaftar';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'ppdb_id',
        'sekolah_id',
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'email',
        'asal_sekolah',
        'status'
    ];

    protected $useTimestamps = true;
}

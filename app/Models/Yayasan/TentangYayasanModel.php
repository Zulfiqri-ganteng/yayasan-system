<?php

namespace App\Models\Yayasan;

use CodeIgniter\Model;

class TentangYayasanModel extends Model
{
    protected $table = 'tentang_yayasan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul',
        'konten',
        'foto_direktur',
        'nama_direktur',
        'banner_image',
        'pesan_direktur'
    ];
    protected $useTimestamps = true;
}

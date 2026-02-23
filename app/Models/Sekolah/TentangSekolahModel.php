<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class TentangSekolahModel extends Model
{
    protected $table      = 'cms_tentang_sekolah';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'konten',
        'banner_image',
        'status'
    ];

    protected $useTimestamps = true;
}

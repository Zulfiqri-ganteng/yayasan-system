<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class GaleriSekolahModel extends Model
{
    protected $table = 'cms_galeri';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'gambar',
        'created_at'
    ];

    protected $useTimestamps = false;
}

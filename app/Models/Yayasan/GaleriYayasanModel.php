<?php

namespace App\Models\Yayasan;

use CodeIgniter\Model;

class GaleriYayasanModel extends Model
{
    protected $table      = 'cms_galeri';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'gambar',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false;
}

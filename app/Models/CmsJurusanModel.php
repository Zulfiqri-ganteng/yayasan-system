<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsJurusanModel extends Model
{
    protected $table            = 'cms_jurusan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'sekolah_id',
        'nama',
        'slug',
        'deskripsi',
        'foto_cover',
        'urutan',
        'status'
    ];

    protected $useTimestamps = true;
}

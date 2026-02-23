<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class VisiMisiSekolahModel extends Model
{
    protected $table      = 'cms_visi_misi_sekolah';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'visi',
        'misi',
        'status'
    ];

    protected $useTimestamps = true;
}

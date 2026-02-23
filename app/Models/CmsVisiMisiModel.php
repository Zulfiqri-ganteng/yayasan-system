<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsVisiMisiModel extends Model
{
    protected $table = 'cms_visi_misi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'visi',
        'misi',
    ];

    protected $useTimestamps = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class FiturJenjangModel extends Model
{
    protected $table = 'fitur_jenjang';
    protected $allowedFields = [
        'jenjang',
        'fitur_kode',
        'default_aktif'
    ];
}

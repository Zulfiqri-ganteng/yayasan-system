<?php

namespace App\Models;

use CodeIgniter\Model;

class FiturModel extends Model
{
    protected $table      = 'fitur';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode',
        'nama',
        'kategori',
    ];

    protected $useTimestamps = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahFiturModel extends Model
{
    protected $table = 'sekolah_fitur';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'fitur_kode',
        'aktif'
    ];

    public $timestamps = false;
}

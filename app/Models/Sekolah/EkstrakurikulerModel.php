<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class EkstrakurikulerModel extends Model
{
    protected $table         = 'cms_ekskul';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'sekolah_id',
        'nama',
        'pembina',
        'jadwal',
        'tempat',
        'slug',
        'gambar',
        'deskripsi',
        'status'
    ];
}

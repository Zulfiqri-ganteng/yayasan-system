<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsEkskulModel extends Model
{
    protected $table      = 'cms_ekskul';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'nama',
        'pembina',
        'gambar',
        'deskripsi'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getAll($sekolahId = null)
    {
        if ($sekolahId) {
            return $this->where('sekolah_id', $sekolahId)
                        ->orderBy('nama', 'ASC')
                        ->findAll();
        }

        return $this->orderBy('nama', 'ASC')->findAll();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsFasilitasModel extends Model
{
    protected $table      = 'cms_fasilitas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'nama_fasilitas',
        'deskripsi',
        'gambar',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getAktif($sekolahId = null)
    {
        $builder = $this->where('is_active', 1);

        if ($sekolahId) {
            $builder->where('sekolah_id', $sekolahId);
        }

        return $builder->orderBy('id', 'DESC')->findAll();
    }
}

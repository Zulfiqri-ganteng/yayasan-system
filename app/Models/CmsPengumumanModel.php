<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsPengumumanModel extends Model
{
    protected $table            = 'cms_pengumuman';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'isi',
        'file',
        'status',
        'tanggal_publish'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil pengumuman berdasarkan sekolah
     */
    public function getBySekolah($sekolahId)
    {
        return $this->where('sekolah_id', $sekolahId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}

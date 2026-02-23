<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsGaleriModel extends Model
{
    protected $table      = 'cms_galeri';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'gambar'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    /**
     * ❗ JANGAN DIPAKAI FRONTEND
     * Untuk admin / debug saja
     */
    public function getAll()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    /**
     * ✅ KHUSUS GALERI YAYASAN (FRONTEND)
     * sekolah_id = 0
     */
    public function getGaleriYayasan()
    {
        return $this->where('sekolah_id', 0)
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}

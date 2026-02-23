<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsAkademikModel extends Model
{
    protected $table      = 'cms_akademik';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'jenjang',
        'nama_sekolah',
        'deskripsi',
        'foto_sekolah',
        'nama_kepsek',
        'foto_kepsek',
        'urutan',
        'status'
    ];

    protected $useTimestamps = true;

    // =========================
    // QUERY HELPER
    // =========================
    public function aktifYayasan()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    public function byJenjang($jenjang)
    {
        return $this->where('jenjang', $jenjang)
                    ->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->first();
    }
}

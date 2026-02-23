<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsStaffModel extends Model
{
    protected $table      = 'cms_staff';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'level',
        'nama',
        'jabatan',
        'foto',
        'urutan',
        'status',
        'instagram',
        'facebook',
        'linkedin',
        'wali_kelas'
    ];

    /**
     * STAFF YAYASAN
     */
    public function staffYayasan()
    {
        return $this->where('level', 'yayasan')
            ->where('sekolah_id', null) // 🔥 INI KUNCI
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }


    /**
     * STAFF SEKOLAH
     */
    public function staffSekolah($sekolahId)
    {
        return $this->where('level', 'sekolah')
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }
}

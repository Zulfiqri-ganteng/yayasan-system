<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsHomeModel extends Model
{
    protected $table            = 'cms_home';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'sekolah_id',
        'hero_title',
        'hero_subtitle',
        'hero_image1',
        'hero_image2',
        'hero_image3',
        'hero_image4',
        'hero_image5',
        'hero_image6',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil data home berdasarkan sekolah
     */
    public function getHome(int $sekolahId)
    {
        return $this->where('sekolah_id', $sekolahId)->first();
    }
}

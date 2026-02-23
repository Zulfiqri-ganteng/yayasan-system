<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class HomeSekolahModel extends Model
{
    protected $table = 'cms_home_sekolah';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'hero_title',
        'hero_subtitle',
        'hero_image_1',
        'hero_image_2',
        'hero_image_3',
    ];

    protected $useTimestamps = true;
}

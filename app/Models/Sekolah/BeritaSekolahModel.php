<?php

namespace App\Models\Sekolah;

use CodeIgniter\Model;

class BeritaSekolahModel extends Model
{
    protected $table      = 'cms_berita';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'level',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'featured_image',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}

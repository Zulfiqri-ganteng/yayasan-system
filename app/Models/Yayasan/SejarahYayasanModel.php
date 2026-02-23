<?php

namespace App\Models\Yayasan;

use CodeIgniter\Model;

class SejarahYayasanModel extends Model
{
    protected $table            = 'sejarah_yayasan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'tahun',
        'judul',
        'deskripsi',
        'urutan',
        'status'
    ];

    protected $useTimestamps = true;
}

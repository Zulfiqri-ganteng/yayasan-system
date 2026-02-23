<?php

namespace App\Models\Yayasan;

use CodeIgniter\Model;

class ProfilYayasanModel extends Model
{
    protected $table            = 'profil_yayasan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_yayasan',
        'slogan',
        'logo',
        'alamat',
        'email',
        'telepon',
        'website',
        'google_maps',
        'deskripsi_singkat'
    ];

    protected $useTimestamps = true;
}

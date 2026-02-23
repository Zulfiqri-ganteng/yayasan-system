<?php
namespace App\Models\Sekolah;

use CodeIgniter\Model;

class PpdbModel extends Model
{
    protected $table = 'ppdb';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sekolah_id',
        'judul',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'banner',
        'deskripsi',
        'status'
    ];
}

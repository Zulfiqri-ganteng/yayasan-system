<?php

namespace App\Models;

use CodeIgniter\Model;

class CmsBeritaModel extends Model
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
        'is_highlight',
        'status',
    ];

    protected $useTimestamps = true;
    public function getPublish($limit = 6, $sekolahId = null)
    {
        $builder = $this->where('status', 'publish');

        if ($sekolahId !== null) {
            $builder->where('sekolah_id', $sekolahId);
        }

        return $builder
            ->orderBy('created_at', 'DESC')
            ->find($limit);
    }
    // ===== QUERY HELPER =====

    public function beritaYayasan(int $limit = 10): array
    {
        return $this->db->table($this->table)
            ->where('level', 'yayasan')
            ->where('status', 'publish')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }


    public function beritaSekolah($sekolahId, $limit = 10)
    {
        return $this->where('level', 'sekolah')
            ->where('sekolah_id', $sekolahId)
            ->where('status', 'publish')
            ->orderBy('created_at', 'DESC')
            ->find($limit);
    }

    public function highlightKeYayasan($limit = 5)
    {
        return $this->where('level', 'sekolah')
            ->where('is_highlight', 1)
            ->where('status', 'publish')
            ->orderBy('created_at', 'DESC')
            ->find($limit);
    }
}

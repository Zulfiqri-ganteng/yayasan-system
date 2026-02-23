<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SekolahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_sekolah' => 'Yayasan Galajuara',
                'jenjang'      => 'yayasan',
                'subdomain'    => 'galajuara',
                'status'       => 1,
            ],
            [
                'nama_sekolah' => 'TK Galajuara',
                'jenjang'      => 'tk',
                'subdomain'    => 'tkgalajuara',
                'status'       => 1,
            ],
            [
                'nama_sekolah' => 'SD Galajuara',
                'jenjang'      => 'sd',
                'subdomain'    => 'sdgalajuara',
                'status'       => 1,
            ],
            [
                'nama_sekolah' => 'SMP Persada',
                'jenjang'      => 'smp',
                'subdomain'    => 'smppersada',
                'status'       => 1,
            ],
            [
                'nama_sekolah' => 'SMA Galajuara',
                'jenjang'      => 'sma',
                'subdomain'    => 'smagalajuara',
                'status'       => 1,
            ],
            [
                'nama_sekolah' => 'SMK Galajuara',
                'jenjang'      => 'smk',
                'subdomain'    => 'smkgalajuara',
                'status'       => 1,
            ],
        ];

        $this->db->table('sekolah')->insertBatch($data);
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'sekolah_id' => null, // superadmin tidak terikat sekolah
            'username'   => 'superadmin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'superadmin',
            'status'     => 1,
        ]);
    }
}

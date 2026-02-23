<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'jenjang' => [
                'type' => 'ENUM',
                'constraint' => ['yayasan','tk','sd','smp','sma','smk'],
            ],
            'subdomain' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'TINYINT',
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('sekolah');
    }
}

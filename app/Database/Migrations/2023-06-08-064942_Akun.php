<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Akun extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_akun' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'no_akun' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'nama_akun' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ]
        ]);
        $this->forge->addKey('id_akun', true);
        $this->forge->createTable('akun');
    }

    public function down()
    {
        $this->forge->dropTable('akun');
    }
}

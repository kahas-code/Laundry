<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Services extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_service' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'kode_service' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
            ],
            'nama_service' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'harga_service' => [
                'type' => 'VARCHAR',
                'constraint' => '7'
            ],
        ]);
        $this->forge->addKey('id_service', true);
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}

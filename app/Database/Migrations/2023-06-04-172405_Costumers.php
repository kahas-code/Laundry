<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Costumers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_costumer' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'kode_costumer' => [
                'type' => 'VARCHAR',
                'constraint' => '30'
            ],
            'nama_costumer' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => '15'
            ],
        ]);
        $this->forge->addKey('id_costumer', true);
        $this->forge->createTable('costumers');
    }

    public function down()
    {
        $this->forge->dropTable('costumers');
    }
}

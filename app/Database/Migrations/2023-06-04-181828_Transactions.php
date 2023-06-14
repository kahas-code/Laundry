<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaction' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'transaction_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'service_code' => [
                'type' => 'VARCHAR',
                'constraint' => 7
            ],
            'costumer_code' => [
                'type' => 'VARCHAR',
                'constraint' => 7
            ],
            'berat_pakaian' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'total' => [
                'type' => 'VARCHAR',
                'constraint' => 7
            ],
            'jumlah_bayar' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => NULL
            ],
            'kembalian' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => NULL
            ],
            'status' => [
                'type' => 'TINYINT',
                'default' => 0
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('id_transaction', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}

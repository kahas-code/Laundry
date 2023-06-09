<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Journals extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_journal' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true

            ],
            'no_journal' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'no_akun' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'no_trx' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'debit' => [
                'type' => 'VARCHAR',
                'constraint' => '10'
            ],
            'kredit' => [
                'type' => 'VARCHAR',
                'constraint' => '10'
            ],
            'tanggal_jurnal datetime default current_timestamp',
        ]);
        $this->forge->addKey('id_journal', true);
        $this->forge->createTable('journals');
    }

    public function down()
    {
        $this->forge->dropTable('journals');
    }
}

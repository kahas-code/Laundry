<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '250'
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => NULL
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => NULL
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ],
            'tanggal_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'default' => NULL
            ],
            'role' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ],
            'isLogin' => [
                'type' => 'TINYINT',

            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');
        $data = [[
            'nama' => 'Pemilik',
            'email' => 'pemilik@mail.com',
            'username' => 'pemilik',
            'password' => password_hash('123456', PASSWORD_BCRYPT),
            'role' => '0'
        ], [
            'nama' => 'admin',
            'email' => 'admin@mail.com',
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'role' => '1'
        ]];
        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}

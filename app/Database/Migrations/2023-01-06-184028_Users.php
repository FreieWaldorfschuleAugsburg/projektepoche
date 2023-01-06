<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'autoincrement' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'group_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('group_id', GROUPS, 'id');
        $this->forge->createTable(USERS);
    }

    public function down()
    {
        $this->forge->dropTable(USERS);
    }
}

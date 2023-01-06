<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Groups extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unisgned' => true,
                'autoincrement' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'admin' => [
                'type' => 'TINYINT',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable(GROUPS);
    }

    public function down()
    {
        $this->forge->dropTable(GROUPS);
    }
}

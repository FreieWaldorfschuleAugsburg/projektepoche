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
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'voting' => [
                'type' => 'TINYINT',
                'unsigned' => true
            ],
            'admin' => [
                'type' => 'TINYINT',
                'unsigned' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable(GROUPS);

    }

    public function down()
    {
        $this->forge->dropTable(GROUPS);
    }
}

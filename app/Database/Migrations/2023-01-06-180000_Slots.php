<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Slots extends Migration
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
            'start_time' => [
                'type' => 'INT',
            ],
            'end_time' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable(SLOTS);
    }

    public function down()
    {
        $this->forge->dropTable(SLOTS);
    }
}

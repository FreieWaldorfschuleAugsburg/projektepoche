<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Projects extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'slot_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'max_members' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'room' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('slot_id', SLOTS, 'id');
        $this->forge->createTable(PROJECTS);
    }

    public function down()
    {
        $this->forge->dropTable(PROJECTS);
    }
}

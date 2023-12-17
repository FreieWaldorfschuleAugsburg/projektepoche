<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up(): void
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
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'group_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'last_activity' => [
                'type' => 'TIMESTAMP',
                'unsigned' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('group_id', GROUPS, 'id');
        $this->forge->createTable(USERS);
    }

    public function down(): void
    {
        $this->forge->dropTable(USERS);
    }
}

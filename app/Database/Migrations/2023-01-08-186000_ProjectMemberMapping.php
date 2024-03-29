<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProjectMemberMapping extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'project_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', USERS, 'id');
        $this->forge->addForeignKey('project_id', PROJECTS, 'id', 'cascade', 'cascade');
        $this->forge->createTable(MEMBERS);
    }

    public function down(): void
    {
        $this->forge->dropTable(MEMBERS);
    }
}

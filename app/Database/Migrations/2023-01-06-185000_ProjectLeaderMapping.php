<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProjectLeaderMapping extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'autoincrement' => true
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
        $this->forge->addForeignKey('project_id', PROJECTS, 'id');
        $this->forge->createTable(LEADERS);
    }

    public function down()
    {
        $this->forge->dropTable(LEADERS);
    }
}

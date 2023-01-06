<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Votes extends Migration
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
                'unsigned' => true,
            ],
            'slot_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'vote_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'project_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

        ]);
    }

    public function down()
    {
        //
    }
}

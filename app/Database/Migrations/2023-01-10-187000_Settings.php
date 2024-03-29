<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Settings extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);
        $this->forge->addKey('name', true);
        $this->forge->createTable(SETTINGS);
    }

    public function down(): void
    {
        $this->forge->dropTable(SETTINGS);
    }
}

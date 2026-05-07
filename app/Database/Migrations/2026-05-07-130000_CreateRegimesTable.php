<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegimesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'calories_per_day' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'description' => [
                'type'    => 'TEXT',
                'null'    => true,
            ],
            'difficulty' => [
                'type'       => 'ENUM',
                'constraint' => ['easy', 'medium', 'hard'],
                'default'    => 'medium',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('regimes', true);
    }

    public function down()
    {
        $this->forge->dropTable('regimes', true);
    }
}

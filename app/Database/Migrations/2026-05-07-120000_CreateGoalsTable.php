<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGoalsTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['gain', 'lose', 'reach_ideal'],
                'null'       => false,
            ],
            'target_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => false,
                'comment'    => 'Target weight (kg) or target IMC',
            ],
            'duration_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'start_date' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'end_date' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'active', 'completed', 'cancelled'],
                'default'    => 'pending',
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
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->createTable('goals', true);
    }

    public function down()
    {
        $this->forge->dropTable('goals', true);
    }
}

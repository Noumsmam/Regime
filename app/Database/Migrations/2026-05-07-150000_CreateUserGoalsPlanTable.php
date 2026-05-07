<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserGoalsPlanTable extends Migration
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
            'goal_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'regime_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'activity_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'minutes_per_day' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 30,
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
        $this->forge->addKey('goal_id');
        $this->forge->addKey('regime_id');
        $this->forge->addKey('activity_id');
        $this->forge->createTable('user_goals_plan', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_goals_plan', true);
    }
}

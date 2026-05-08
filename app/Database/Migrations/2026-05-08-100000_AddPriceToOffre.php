<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPriceToOffre extends Migration
{
    public function up()
    {
        $this->forge->addColumn('offre', [
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => null,
                'after' => 'remise'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'price'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('offre', ['price', 'created_at', 'updated_at']);
    }
}

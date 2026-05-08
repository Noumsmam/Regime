<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserRegimePurchases extends Migration
{
    public function up()
    {
        // Ajouter le champ prix aux régimes (s'il n'existe pas)
        $fields = $this->db->getFieldData('regimes');
        $priceExists = false;
        
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if ($field->name === 'price') {
                    $priceExists = true;
                    break;
                }
            }
        }

        if (!$priceExists) {
            $this->forge->addColumn('regimes', [
                'price' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'null' => true,
                    'default' => null,
                    'after' => 'pourcentage_volaille'
                ]
            ]);
        }

        // Créer la table pour les achats de régimes
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'regime_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'price_paid' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'discount_applied' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'null' => false,
            ],
            'purchased_at' => [
                'type' => 'DATETIME',
                'null' => false,
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
        $this->forge->addKey('regime_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('regime_id', 'regimes', 'id', '', 'CASCADE');
        $this->forge->createTable('user_regime_purchases', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_regime_purchases', true);
        
        $fields = $this->db->getFieldData('regimes');
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if ($field->name === 'price') {
                    $this->forge->dropColumn('regimes', 'price');
                    break;
                }
            }
        }
    }
}

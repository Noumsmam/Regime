<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDurationToUserRegimePurchases extends Migration
{
    private function hasDurationColumn(): bool
    {
        $result = $this->db->query("SHOW COLUMNS FROM user_regime_purchases LIKE 'duration_days'")->getResultArray();
        return !empty($result);
    }

    public function up()
    {
        $tableExists = $this->db->query("SHOW TABLES LIKE 'user_regime_purchases'")->getResultArray();
        if (empty($tableExists)) {
            return;
        }

        if (!$this->hasDurationColumn()) {
            $this->forge->addColumn('user_regime_purchases', [
                'duration_days' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                    'default' => 30,
                    'after' => 'discount_applied',
                ],
            ]);
        }
    }

    public function down()
    {
        $tableExists = $this->db->query("SHOW TABLES LIKE 'user_regime_purchases'")->getResultArray();
        if (empty($tableExists)) {
            return;
        }

        if ($this->hasDurationColumn()) {
            $this->forge->dropColumn('user_regime_purchases', 'duration_days');
        }
    }
}
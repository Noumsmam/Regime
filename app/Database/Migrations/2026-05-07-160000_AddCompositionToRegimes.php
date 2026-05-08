<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCompositionToRegimes extends Migration
{
    public function up()
    {
        // Les colonnes de composition sont déjà créées dans init.sql
        // Cette migration est conservée pour la cohérence mais n'ajoute rien
        // $this->forge->addColumn('regimes', [
        //     'pourcentage_viande' => [
        //         'type'       => 'DECIMAL',
        //         'constraint' => '5,2',
        //         'default'    => 0,
        //         'comment'    => 'Pourcentage de viande (0-100)',
        //     ],
        //     'pourcentage_poisson' => [
        //         'type'       => 'DECIMAL',
        //         'constraint' => '5,2',
        //         'default'    => 0,
        //         'comment'    => 'Pourcentage de poisson (0-100)',
        //     ],
        //     'pourcentage_volaille' => [
        //         'type'       => 'DECIMAL',
        //         'constraint' => '5,2',
        //         'default'    => 0,
        //         'comment'    => 'Pourcentage de volaille (0-100)',
        //     ],
        // ]);
    }

    public function down()
    {
        $this->forge->dropColumn('regimes', ['pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille']);
    }
}

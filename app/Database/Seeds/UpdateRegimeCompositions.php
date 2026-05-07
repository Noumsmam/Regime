<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateRegimeCompositions extends Seeder
{
    public function run()
    {
        // Update regimes with correct compositions (total = 100%)
        $db = $this->db;

        // Update each regime
        $updates = [
            ['id' => 1, 'pourcentage_viande' => 33, 'pourcentage_poisson' => 33, 'pourcentage_volaille' => 34],
            ['id' => 2, 'pourcentage_viande' => 30, 'pourcentage_poisson' => 35, 'pourcentage_volaille' => 35],
            ['id' => 3, 'pourcentage_viande' => 20, 'pourcentage_poisson' => 40, 'pourcentage_volaille' => 40],
            ['id' => 4, 'pourcentage_viande' => 40, 'pourcentage_poisson' => 30, 'pourcentage_volaille' => 30],
            ['id' => 5, 'pourcentage_viande' => 35, 'pourcentage_poisson' => 33, 'pourcentage_volaille' => 32],
        ];

        foreach ($updates as $update) {
            $db->table('regimes')->where('id', $update['id'])->update([
                'pourcentage_viande'     => $update['pourcentage_viande'],
                'pourcentage_poisson'    => $update['pourcentage_poisson'],
                'pourcentage_volaille'   => $update['pourcentage_volaille'],
            ]);
        }

        echo "Régimes compositions mises à jour avec succès!\n";
    }
}

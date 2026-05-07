<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegimeActivitySeeder extends Seeder
{
    public function run()
    {
        // Seed regimes (5 regimes) with composition percentages
        $regimes = [
            [
                'name'                      => 'Régime Léger - Maintien',
                'calories_per_day'          => 2000,
                'description'               => 'Régime équilibré pour maintenir son poids avec 2000 calories par jour.',
                'difficulty'                => 'easy',
                'pourcentage_viande'        => 30,
                'pourcentage_poisson'       => 20,
                'pourcentage_volaille'      => 20,
            ],
            [
                'name'                      => 'Régime Amaigrissant - Modéré',
                'calories_per_day'          => 1500,
                'description'               => 'Régime modéré pour perdre du poids progressivement : 1500 calories par jour.',
                'difficulty'                => 'medium',
                'pourcentage_viande'        => 25,
                'pourcentage_poisson'       => 30,
                'pourcentage_volaille'      => 25,
            ],
            [
                'name'                      => 'Régime Amaigrissant - Intensif',
                'calories_per_day'          => 1200,
                'description'               => 'Régime intensif pour une perte de poids rapide : 1200 calories par jour.',
                'difficulty'                => 'hard',
                'pourcentage_viande'        => 20,
                'pourcentage_poisson'       => 40,
                'pourcentage_volaille'      => 30,
            ],
            [
                'name'                      => 'Régime Gainant - Modéré',
                'calories_per_day'          => 2800,
                'description'               => 'Régime pour prendre du poids sainement : 2800 calories par jour riche en protéines.',
                'difficulty'                => 'medium',
                'pourcentage_viande'        => 40,
                'pourcentage_poisson'       => 20,
                'pourcentage_volaille'      => 30,
            ],
            [
                'name'                      => 'Régime Gainant - Intensif',
                'calories_per_day'          => 3500,
                'description'               => 'Régime intensif pour prendre du poids rapidement : 3500 calories par jour.',
                'difficulty'                => 'hard',
                'pourcentage_viande'        => 35,
                'pourcentage_poisson'       => 25,
                'pourcentage_volaille'      => 35,
            ],
        ];

        foreach ($regimes as $regime) {
            $this->db->table('regimes')->insert($regime);
        }

        // Seed activities (5 activités)
        $activities = [
            [
                'name'                    => 'Marche rapide',
                'calories_burn_per_hour'  => 300,
                'intensity'               => 'low',
            ],
            [
                'name'                    => 'Jogging',
                'calories_burn_per_hour'  => 600,
                'intensity'               => 'medium',
            ],
            [
                'name'                    => 'Course à pied',
                'calories_burn_per_hour'  => 800,
                'intensity'               => 'high',
            ],
            [
                'name'                    => 'Musculation',
                'calories_burn_per_hour'  => 500,
                'intensity'               => 'medium',
            ],
            [
                'name'                    => 'Cardio intense (HIIT)',
                'calories_burn_per_hour'  => 900,
                'intensity'               => 'high',
            ],
        ];

        foreach ($activities as $activity) {
            $this->db->table('activities')->insert($activity);
        }

        echo "Regimes and Activities seeded successfully!";
    }
}

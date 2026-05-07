<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegimeActivitySeeder extends Seeder
{
    public function run()
    {
        // Seed regimes (5 regimes)
        $regimes = [
            [
                'name'              => 'Régime Léger - Maintien',
                'calories_per_day'  => 2000,
                'description'       => 'Régime équilibré pour maintenir son poids avec 2000 calories par jour.',
                'difficulty'        => 'easy',
            ],
            [
                'name'              => 'Régime Amaigrissant - Modéré',
                'calories_per_day'  => 1500,
                'description'       => 'Régime modéré pour perdre du poids progressivement : 1500 calories par jour.',
                'difficulty'        => 'medium',
            ],
            [
                'name'              => 'Régime Amaigrissant - Intensif',
                'calories_per_day'  => 1200,
                'description'       => 'Régime intensif pour une perte de poids rapide : 1200 calories par jour.',
                'difficulty'        => 'hard',
            ],
            [
                'name'              => 'Régime Gainant - Modéré',
                'calories_per_day'  => 2800,
                'description'       => 'Régime pour prendre du poids sainement : 2800 calories par jour riche en protéines.',
                'difficulty'        => 'medium',
            ],
            [
                'name'              => 'Régime Gainant - Intensif',
                'calories_per_day'  => 3500,
                'description'       => 'Régime intensif pour prendre du poids rapidement : 3500 calories par jour.',
                'difficulty'        => 'hard',
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

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OffreSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'libelle'  => 'Gold',
                'remise'   => 15.00,
                'price'    => 9.99,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'libelle'  => 'Silver',
                'remise'   => 5.00,
                'price'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('offre')->insertBatch($data);
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $coupons = [
            [
                'code'       => '500001',
                'amount'     => 500,
                'is_active'  => 1,
                'expires_at' => null,
                'max_uses'   => null,
                'used_count' => 0,
            ],
            [
                'code'       => '500002',
                'amount'     => 1000,
                'is_active'  => 1,
                'expires_at' => null,
                'max_uses'   => null,
                'used_count' => 0,
            ],
            [
                'code'       => '500003',
                'amount'     => 1500,
                'is_active'  => 1,
                'expires_at' => null,
                'max_uses'   => null,
                'used_count' => 0,
            ],
            [
                'code'       => '500004',
                'amount'     => 2000,
                'is_active'  => 1,
                'expires_at' => null,
                'max_uses'   => null,
                'used_count' => 0,
            ],
            [
                'code'       => '500005',
                'amount'     => 3000,
                'is_active'  => 1,
                'expires_at' => null,
                'max_uses'   => null,
                'used_count' => 0,
            ],
        ];

        foreach ($coupons as $coupon) {
            $exists = $this->db->table('coupons')->where('code', $coupon['code'])->get()->getRowArray();
            if (!$exists) {
                $this->db->table('coupons')->insert($coupon);
            }
        }
    }
}

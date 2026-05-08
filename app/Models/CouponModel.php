<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table            = 'coupons';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'amount', 'is_active', 'expires_at', 'max_uses', 'used_count'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findValidByCode(string $code): ?array
    {
        $coupon = $this->where('code', strtoupper(trim($code)))
            ->where('is_active', 1)
            ->first();

        if (!$coupon) {
            return null;
        }

        if (!empty($coupon['expires_at']) && strtotime($coupon['expires_at']) < time()) {
            return null;
        }

        if (!is_null($coupon['max_uses']) && (int) $coupon['used_count'] >= (int) $coupon['max_uses']) {
            return null;
        }

        return $coupon;
    }
}

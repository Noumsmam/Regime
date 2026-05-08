<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponRedemptionModel extends Model
{
    protected $table            = 'coupon_redemptions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'coupon_id', 'amount', 'redeemed_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function alreadyRedeemed(int $userId, int $couponId): bool
    {
        return $this->where('user_id', $userId)
            ->where('coupon_id', $couponId)
            ->first() !== null;
    }
}

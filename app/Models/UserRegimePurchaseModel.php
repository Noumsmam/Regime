<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRegimePurchaseModel extends Model
{
    protected $table            = 'user_regime_purchases';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'price_paid',
        'discount_applied',
        'duration_days',
        'purchased_at',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Check if user has already purchased a regime
     */
    public function hasPurchased(int $userId, int $regimeId): bool
    {
        return $this->where('user_id', $userId)
            ->where('regime_id', $regimeId)
            ->get()
            ->getNumRows() > 0;
    }

    /**
     * Get all purchased regimes for a user
     */
    public function getUserPurchases(int $userId): array
    {
        return $this->select('user_regime_purchases.*, regimes.name')
            ->join('regimes', 'regimes.id = user_regime_purchases.regime_id')
            ->where('user_regime_purchases.user_id', $userId)
            ->orderBy('user_regime_purchases.purchased_at', 'DESC')
            ->findAll();
    }
}

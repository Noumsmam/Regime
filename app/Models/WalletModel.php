<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table            = 'wallets';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'balance'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getOrCreateByUserId(int $userId): array
    {
        $wallet = $this->where('user_id', $userId)->first();

        if ($wallet) {
            return $wallet;
        }

        $walletId = $this->insert([
            'user_id' => $userId,
            'balance' => 0,
        ]);

        return $this->find($walletId);
    }

    public function addBalance(int $userId, float $amount): bool
    {
        $wallet = $this->getOrCreateByUserId($userId);
        $newBalance = (float) $wallet['balance'] + $amount;

        return (bool) $this->update($wallet['id'], ['balance' => $newBalance]);
    }
}

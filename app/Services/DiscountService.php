<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;

class DiscountService
{
    protected $db;

    public function __construct(BaseConnection $db = null)
    {
        $this->db = $db ?? db_connect();
    }

    /**
     * Vérifier si l'utilisateur a une option spécifique
     */
    public function hasOption(int $userId, string $libelle): bool
    {
        $result = $this->db->table('userOffre')
            ->select('userOffre.id')
            ->join('offre', 'offre.id = userOffre.id_offre')
            ->where('userOffre.id_user', $userId)
            ->where('offre.libelle', $libelle)
            ->get()
            ->getNumRows();

        return $result > 0;
    }

    /**
     * Obtenir le taux de remise de l'utilisateur
     */
    public function getDiscountPercentage(int $userId): float
    {
        $result = $this->db->table('userOffre')
            ->select('MAX(offre.remise) as max_remise')
            ->join('offre', 'offre.id = userOffre.id_offre')
            ->where('userOffre.id_user', $userId)
            ->get()
            ->getFirstRow('array');

        return (float)($result['max_remise'] ?? 0);
    }

    /**
     * Calculer le prix avec remise
     */
    public function applyDiscount(float $price, float $discountPercentage): float
    {
        return $price * (1 - ($discountPercentage / 100));
    }

    /**
     * Obtenir toutes les options de l'utilisateur
     */
    public function getUserOptions(int $userId): array
    {
        return $this->db->table('userOffre')
            ->select('offre.id, offre.libelle, offre.remise')
            ->join('offre', 'offre.id = userOffre.id_offre')
            ->where('userOffre.id_user', $userId)
            ->get()
            ->getResultArray();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class OffreModel extends Model
{
    protected $table            = 'offre';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'libelle',
        'remise',
        'price',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get offre by libelle
     */
    public function getByLibelle(string $libelle)
    {
        return $this->where('libelle', $libelle)->first();
    }

    /**
     * Get all offres with price (paid options)
     */
    public function getPaidOffres()
    {
        $db = db_connect();
        $columns = $db->getFieldData('offre');
        $priceColumnExists = false;

        if (is_array($columns)) {
            foreach ($columns as $col) {
                if ($col->name === 'price') {
                    $priceColumnExists = true;
                    break;
                }
            }
        }

        $offres = $this->findAll();

        foreach ($offres as &$offre) {
            if ((!isset($offre['price']) || $offre['price'] === null || $offre['price'] === '') && ($offre['libelle'] ?? '') === 'Gold') {
                $offre['price'] = 9.99;
            }
        }

        return array_values(array_filter($offres, static function (array $offre) use ($priceColumnExists): bool {
            if (!$priceColumnExists) {
                return ($offre['libelle'] ?? '') === 'Gold';
            }

            return isset($offre['price']) && $offre['price'] !== null && $offre['price'] !== '';
        }));
    }
}

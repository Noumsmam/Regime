<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table            = 'regimes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'calories_per_day', 'description', 'difficulty', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    public function getByDifficulty($difficulty)
    {
        return $this->where('difficulty', $difficulty)->findAll();
    }

    public function getByCalorieRange($minCal, $maxCal)
    {
        return $this->where('calories_per_day >=', $minCal)
                    ->where('calories_per_day <=', $maxCal)
                    ->findAll();
    }

    public function getRandomByDifficulty($difficulty)
    {
        return $this->where('difficulty', $difficulty)
                    ->orderBy('RAND()')
                    ->first();
    }
}

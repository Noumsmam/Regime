<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table            = 'activities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'calories_burn_per_hour', 'intensity'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    public function getByIntensity($intensity)
    {
        return $this->where('intensity', $intensity)->findAll();
    }

    public function getRandomByIntensity($intensity)
    {
        return $this->where('intensity', $intensity)
                    ->orderBy('RAND()')
                    ->first();
    }
}

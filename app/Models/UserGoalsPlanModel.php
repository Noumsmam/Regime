<?php

namespace App\Models;

use CodeIgniter\Model;

class UserGoalsPlanModel extends Model
{
    protected $table            = 'user_goals_plan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['goal_id', 'regime_id', 'activity_id', 'minutes_per_day'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    public function getPlanForGoal($goalId)
    {
        return $this->select('user_goals_plan.*, regimes.name as regime_name, regimes.calories_per_day, regimes.description as regime_description, regimes.pourcentage_viande, regimes.pourcentage_poisson, regimes.pourcentage_volaille, regimes.price as regime_price, activities.name as activity_name, activities.calories_burn_per_hour')
                    ->join('regimes', 'regimes.id = user_goals_plan.regime_id', 'left')
                    ->join('activities', 'activities.id = user_goals_plan.activity_id', 'left')
                    ->where('goal_id', $goalId)
                    ->first();
    }

    public function createPlan($goalId, $regimeId, $activityId, $minutesPerDay = 30)
    {
        return $this->insert([
            'goal_id'        => $goalId,
            'regime_id'      => $regimeId,
            'activity_id'    => $activityId,
            'minutes_per_day' => $minutesPerDay,
        ]);
    }
}

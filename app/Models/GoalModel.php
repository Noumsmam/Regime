<?php

namespace App\Models;

use CodeIgniter\Model;

class GoalModel extends Model
{
    protected $table            = 'goals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'type', 'target_value', 'duration_days', 'start_date', 'end_date', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    public function getUserGoals($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function getActiveGoal($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('status', 'active')
                    ->first();
    }

    public function getGoalById($goalId, $userId)
    {
        return $this->where('id', $goalId)
                    ->where('user_id', $userId)
                    ->first();
    }

    public function createGoal($userId, $type, $targetValue, $durationDays)
    {
        return $this->insert([
            'user_id'       => $userId,
            'type'          => $type,
            'target_value'  => $targetValue,
            'duration_days' => $durationDays,
            'status'        => 'pending',
        ]);
    }

    public function activateGoal($goalId, $userId)
    {
        $goal = $this->find($goalId);
        if (!$goal) {
            return false;
        }

        $endDate = date('Y-m-d H:i:s', strtotime('+' . $goal['duration_days'] . ' days'));

        return $this->where('id', $goalId)
                    ->where('user_id', $userId)
                    ->update([
                        'status'     => 'active',
                        'start_date' => date('Y-m-d H:i:s'),
                        'end_date'   => $endDate,
                    ]);
    }

    public function completeGoal($goalId, $userId)
    {
        return $this->where('id', $goalId)
                    ->where('user_id', $userId)
                    ->update(['status' => 'completed']);
    }
}

<?php

namespace App\Services;

use App\Models\GoalModel;
use App\Models\UserModel;

class GoalService
{
    protected $goalModel;
    protected $userModel;
    protected $imcService;

    public function __construct()
    {
        $this->goalModel  = new GoalModel();
        $this->userModel   = new UserModel();
        $this->imcService  = new ImcService();
    }

    public function createGoal($userId, $type, $targetValue, $durationDays)
    {
        if (!$this->validateGoalInput($type, $targetValue, $durationDays)) {
            return false;
        }

        if (!in_array($type, ['gain', 'lose', 'reach_ideal'])) {
            return false;
        }

        return $this->goalModel->createGoal($userId, $type, $targetValue, $durationDays);
    }

    public function activateGoal($goalId, $userId)
    {
        $goal = $this->goalModel->getGoalById($goalId, $userId);
        if (!$goal || $goal['status'] !== 'pending') {
            return false;
        }

        return $this->goalModel->activateGoal($goalId, $userId);
    }

    public function getUserGoalsWithProgress($userId)
    {
        $goals = $this->goalModel->getUserGoals($userId);
        $userInfo = $this->userModel->getUserWithInfo($userId);

        if (!$userInfo) {
            return [];
        }

        $currentWeight = (float) $userInfo['poids'];
        $currentImc = $this->imcService->calculateImc($currentWeight, (float) $userInfo['taille']);

        return array_map(function ($goal) use ($currentWeight, $currentImc) {
            $goal['current_weight'] = $currentWeight;
            $goal['current_imc'] = $currentImc;
            $goal['progress'] = $this->calculateProgress($goal, $currentWeight, $currentImc);
            return $goal;
        }, $goals);
    }

    public function suggestRegimeCharacteristics($type, $durationDays)
    {
        $weeksDuration = ceil($durationDays / 7);

        $characteristics = [
            'type'           => $type,
            'duration_days'   => $durationDays,
            'weeks'           => $weeksDuration,
            'intensity'       => 'moderate',
            'calories_range'  => [1500, 2500],
        ];

        if ($type === 'lose') {
            $characteristics['intensity']      = 'high';
            $characteristics['calories_range'] = $weeksDuration <= 4 ? [1500, 2000] : [1200, 1800];
        } elseif ($type === 'gain') {
            $characteristics['intensity']      = 'low';
            $characteristics['calories_range'] = [2500, 3500];
        } elseif ($type === 'reach_ideal') {
            $characteristics['intensity']      = 'moderate';
            $characteristics['calories_range'] = [1800, 2200];
        }

        return $characteristics;
    }

    private function calculateProgress($goal, $currentWeight, $currentImc)
    {
        if ($goal['type'] === 'reach_ideal') {
            return ($currentImc >= 18.5 && $currentImc <= 24.9) ? 100 : 0;
        }

        $targetValue = (float) $goal['target_value'];
        $durationDays = (int) $goal['duration_days'];

        if ($goal['type'] === 'lose') {
            $total = max(0.01, $currentWeight - $targetValue);
            $done = max(0, $currentWeight - $targetValue);
            return min(100, ($done / $total) * 100);
        }

        if ($goal['type'] === 'gain') {
            $total = max(0.01, $targetValue - $currentWeight);
            $done = max(0, $targetValue - $currentWeight);
            return min(100, ($done / $total) * 100);
        }

        return 0;
    }

    private function validateGoalInput($type, $targetValue, $durationDays)
    {
        return !empty($type) && is_numeric($targetValue) && $targetValue > 0
            && is_numeric($durationDays) && $durationDays > 0;
    }
}

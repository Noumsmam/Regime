<?php

namespace App\Services;

use App\Models\GoalModel;
use App\Models\UserModel;
use App\Models\RegimeModel;
use App\Models\ActivityModel;
use App\Models\UserGoalsPlanModel;
use App\Models\UserRegimePurchaseModel;

class GoalService
{
    protected $goalModel;
    protected $userModel;
    protected $imcService;
    protected $regimeModel;
    protected $activityModel;
    protected $userGoalsPlanModel;
    protected $userRegimePurchaseModel;

    private function getDefaultRegimePrice(?string $name): ?float
    {
        $defaults = [
            'Régime Léger - Maintien' => 4.99,
            'Régime Amaigrissant - Modéré' => 6.99,
            'Régime Amaigrissant - Intensif' => 7.99,
            'Régime Gainant - Modéré' => 5.99,
            'Régime Gainant - Intensif' => 8.99,
        ];

        return $name !== null && array_key_exists($name, $defaults) ? $defaults[$name] : null;
    }

    public function __construct()
    {
        $this->goalModel  = new GoalModel();
        $this->userModel   = new UserModel();
        $this->imcService  = new ImcService();
        $this->regimeModel = new RegimeModel();
        $this->activityModel = new ActivityModel();
        $this->userGoalsPlanModel = new UserGoalsPlanModel();
        $this->userRegimePurchaseModel = new UserRegimePurchaseModel();
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

        // Activate the goal
        $activated = $this->goalModel->activateGoal($goalId, $userId);

        // Auto-assign regime and activity based on goal type
        if ($activated) {
            $this->assignPlanToGoal($goal);
        }

        return $activated;
    }

    public function assignPlanToGoal($goal)
    {
        $characteristics = $this->suggestRegimeCharacteristics($goal['type'], $goal['duration_days']);

        // Select regime based on calorie range and difficulty
        $regime = $this->regimeModel->getByCalorieRange(
            $characteristics['calories_range'][0],
            $characteristics['calories_range'][1]
        );

        if (!$regime) {
            $regime = $this->regimeModel->where('difficulty', $characteristics['intensity'])->findAll();
        }

        $selectedRegime = !empty($regime) ? $regime[0] : $this->regimeModel->first();

        // Select activity based on intensity
        $activity = $this->activityModel->where('intensity', $characteristics['intensity'])->findAll();
        $selectedActivity = !empty($activity) ? $activity[0] : $this->activityModel->first();

        // Calculate minutes per day based on goal type
        $minutesPerDay = 30;
        if ($characteristics['intensity'] === 'high') {
            $minutesPerDay = 45;
        } elseif ($characteristics['intensity'] === 'low') {
            $minutesPerDay = 20;
        }

        // Create plan
        if ($selectedRegime && $selectedActivity) {
            $this->userGoalsPlanModel->createPlan(
                $goal['id'],
                $selectedRegime['id'],
                $selectedActivity['id'],
                $minutesPerDay
            );
        }
    }

    public function getGoalWithPlan($goalId, $userId)
    {
        $goal = $this->goalModel->getGoalById($goalId, $userId);
        if (!$goal) {
            return null;
        }

        $goal['plan'] = $this->userGoalsPlanModel->getPlanForGoal($goalId);

        if (!empty($goal['plan'])) {
            $planName = isset($goal['plan']['regime_name']) && is_string($goal['plan']['regime_name'])
                ? $goal['plan']['regime_name']
                : null;
            $rawPrice = $goal['plan']['regime_price'] ?? null;

            if ($rawPrice !== null && $rawPrice !== '') {
                $goal['plan']['display_price'] = (float) $rawPrice;
            } else {
                $goal['plan']['display_price'] = $this->getDefaultRegimePrice($planName);
            }

            $regimeId = (int) ($goal['plan']['regime_id'] ?? 0);
            $purchase = null;
            if ($regimeId > 0) {
                $purchase = $this->userRegimePurchaseModel
                    ->where('user_id', $userId)
                    ->where('regime_id', $regimeId)
                    ->first();
            }

            $goal['plan']['is_purchased'] = $purchase !== null;
            $goal['plan']['purchased_at'] = $purchase['purchased_at'] ?? null;
            $goal['plan']['purchased_price'] = isset($purchase['price_paid']) ? (float) $purchase['price_paid'] : null;
        }

        // Expose exact daily calorie target for the goal (kg difference based).
        if (in_array($goal['type'], ['lose', 'gain'], true)) {
            $goal['daily_calorie_target'] = $this->calculateIdealCaloriesToBurn($userId, $goal);
        } else {
            $goal['daily_calorie_target'] = 0;
        }

        return $goal;
    }

    public function calculateIdealCaloriesToBurn($userId, $goal)
    {
        // Calculate ideal daily calorie burn based on weight difference and duration
        $userInfo = $this->userModel->getUserWithInfo($userId);
        if (!$userInfo) {
            return 0;
        }

        $currentWeight = (float)$userInfo['poids'];
        $targetWeight = (float)$goal['target_value'];
        $durationDays = (int)$goal['duration_days'];

        // 1 kg = approximately 7700 calories
        $caloriesPerKg = 7700;
        $weightDifference = abs($currentWeight - $targetWeight);
        $totalCaloriesDifference = $weightDifference * $caloriesPerKg;
        
        // Distribute over duration
        $dailyCalorieDifference = round($totalCaloriesDifference / $durationDays);
        
        return $dailyCalorieDifference;
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

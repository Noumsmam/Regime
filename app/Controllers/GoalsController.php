<?php

namespace App\Controllers;

class GoalsController extends BaseController
{
    private function currentUserId(): ?int
    {
        $user = session()->get('user');

        if (is_array($user) && isset($user['id'])) {
            return (int) $user['id'];
        }

        $id = session()->get('id');
        return $id ? (int) $id : null;
    }

    /**
     * GET /goals
     * Display list of user's goals
     */
    public function index()
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        $goalService = new \App\Services\GoalService();
        $goalsWithProgress = $goalService->getUserGoalsWithProgress($userId);

        return view('pages/goals/index', [
            'goals' => $goalsWithProgress,
        ]);
    }

    /**
     * GET /goals/create
     * Display form to create a new goal
     */
    public function create()
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        return view('pages/goals/create');
    }

    /**
     * POST /goals/store
     * Store a new goal (form submission)
     */
    public function store()
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        $type        = $this->request->getPost('type');
        $targetValue = $this->request->getPost('target_value');
        $durationDays = $this->request->getPost('duration_days');

        // Validate
        if (empty($type) || empty($targetValue) || empty($durationDays)) {
            session()->setFlashdata('error', 'Tous les champs sont requis.');
            return redirect()->back()->withInput();
        }

        if (!in_array($type, ['gain', 'lose', 'reach_ideal'])) {
            session()->setFlashdata('error', 'Type d\'objectif invalide.');
            return redirect()->back()->withInput();
        }

        if (!is_numeric($targetValue) || $targetValue <= 0) {
            session()->setFlashdata('error', 'La valeur cible doit être un nombre positif.');
            return redirect()->back()->withInput();
        }

        if (!is_numeric($durationDays) || $durationDays <= 0) {
            session()->setFlashdata('error', 'La durée doit être un nombre de jours positif.');
            return redirect()->back()->withInput();
        }

        try {
            $goalService = new \App\Services\GoalService();
            $goalId = $goalService->createGoal(
                $userId,
                $type,
                (float) $targetValue,
                (int) $durationDays
            );

            if (!$goalId) {
                session()->setFlashdata('error', 'Erreur lors de la création de l\'objectif.');
                return redirect()->back()->withInput();
            }

            session()->setFlashdata('success', 'Objectif créé avec succès !');
            return redirect()->to('/goals');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * GET /goals/{id}/activate
     * Activate a goal (start it)
     */
    public function activate($goalId = null)
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        if (!$goalId) {
            session()->setFlashdata('error', 'Objectif non trouvé.');
            return redirect()->to('/goals');
        }

        try {
            $goalService = new \App\Services\GoalService();
            $result = $goalService->activateGoal((int) $goalId, $userId);

            if (!$result) {
                session()->setFlashdata('error', 'Impossible d\'activer cet objectif.');
                return redirect()->to('/goals');
            }

            session()->setFlashdata('success', 'Objectif activé !');
            return redirect()->to('/goals');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur : ' . $e->getMessage());
            return redirect()->to('/goals');
        }
    }

    /**
     * GET /goals/{id}/complete
     * Mark a goal as completed
     */
    public function complete($goalId = null)
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        if (!$goalId) {
            session()->setFlashdata('error', 'Objectif non trouvé.');
            return redirect()->to('/goals');
        }

        try {
            $goalModel = new \App\Models\GoalModel();
            $result = $goalModel->where('id', $goalId)
                                ->where('user_id', $userId)
                                ->update(['status' => 'completed']);

            if (!$result) {
                session()->setFlashdata('error', 'Impossible de compléter cet objectif.');
                return redirect()->to('/goals');
            }

            session()->setFlashdata('success', 'Objectif marqué comme complété !');
            return redirect()->to('/goals');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur : ' . $e->getMessage());
            return redirect()->to('/goals');
        }
    }
}

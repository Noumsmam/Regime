<?php

namespace App\Controllers;

use App\Models\RegimeModel;

class RegimesController extends BaseController
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

    private function isAdmin(): bool
    {
        // For now, check if user exists (assumes all logged-in users are admins for regime management)
        // In production, check user role
        return $this->currentUserId() !== null;
    }

    /**
     * GET /regimes
     * Display list of all regimes
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->findAll();

        return view('pages/regimes/index', [
            'regimes' => $regimes,
        ]);
    }

    /**
     * GET /regimes/create
     * Display form to create a new regime
     */
    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        return view('pages/regimes/create');
    }

    /**
     * POST /regimes/store
     * Store a new regime
     */
    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $regimeModel = new RegimeModel();

        $name                = $this->request->getPost('name');
        $caloriesPerDay      = $this->request->getPost('calories_per_day');
        $description         = $this->request->getPost('description');
        $difficulty          = $this->request->getPost('difficulty');
        $pourcentageViande   = $this->request->getPost('pourcentage_viande') ?? 0;
        $pourcentagePoisson  = $this->request->getPost('pourcentage_poisson') ?? 0;
        $pourcentageVolaille = $this->request->getPost('pourcentage_volaille') ?? 0;

        // Validate required fields
        if (empty($name) || empty($caloriesPerDay) || empty($difficulty)) {
            session()->setFlashdata('error', 'Tous les champs requis doivent être complétés.');
            return redirect()->back()->withInput();
        }

        // Validate difficulty
        if (!in_array($difficulty, ['easy', 'medium', 'hard'])) {
            session()->setFlashdata('error', 'Difficulté invalide.');
            return redirect()->back()->withInput();
        }

        // Validate percentages
        $totalPercentage = (float)$pourcentageViande + (float)$pourcentagePoisson + (float)$pourcentageVolaille;
        if ($totalPercentage > 100) {
            session()->setFlashdata('error', 'La somme des pourcentages ne peut pas dépasser 100%.');
            return redirect()->back()->withInput();
        }

        try {
            $regimeModel->insert([
                'name'                   => $name,
                'calories_per_day'       => (int)$caloriesPerDay,
                'description'            => $description,
                'difficulty'             => $difficulty,
                'pourcentage_viande'     => (float)$pourcentageViande,
                'pourcentage_poisson'    => (float)$pourcentagePoisson,
                'pourcentage_volaille'   => (float)$pourcentageVolaille,
            ]);

            session()->setFlashdata('success', 'Régime créé avec succès !');
            return redirect()->to('/regimes');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur lors de la création du régime : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * GET /regimes/{id}/edit
     * Display form to edit a regime
     */
    public function edit($regimeId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$regimeId) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);

        if (!$regime) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        return view('pages/regimes/edit', [
            'regime' => $regime,
        ]);
    }

    /**
     * POST /regimes/{id}/update
     * Update a regime
     */
    public function update($regimeId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$regimeId) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);

        if (!$regime) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        $name                = $this->request->getPost('name');
        $caloriesPerDay      = $this->request->getPost('calories_per_day');
        $description         = $this->request->getPost('description');
        $difficulty          = $this->request->getPost('difficulty');
        $pourcentageViande   = $this->request->getPost('pourcentage_viande') ?? 0;
        $pourcentagePoisson  = $this->request->getPost('pourcentage_poisson') ?? 0;
        $pourcentageVolaille = $this->request->getPost('pourcentage_volaille') ?? 0;

        // Validate
        if (empty($name) || empty($caloriesPerDay) || empty($difficulty)) {
            session()->setFlashdata('error', 'Tous les champs requis doivent être complétés.');
            return redirect()->back()->withInput();
        }

        if (!in_array($difficulty, ['easy', 'medium', 'hard'])) {
            session()->setFlashdata('error', 'Difficulté invalide.');
            return redirect()->back()->withInput();
        }

        $totalPercentage = (float)$pourcentageViande + (float)$pourcentagePoisson + (float)$pourcentageVolaille;
        if ($totalPercentage > 100) {
            session()->setFlashdata('error', 'La somme des pourcentages ne peut pas dépasser 100%.');
            return redirect()->back()->withInput();
        }

        try {
            $regimeModel->update($regimeId, [
                'name'                   => $name,
                'calories_per_day'       => (int)$caloriesPerDay,
                'description'            => $description,
                'difficulty'             => $difficulty,
                'pourcentage_viande'     => (float)$pourcentageViande,
                'pourcentage_poisson'    => (float)$pourcentagePoisson,
                'pourcentage_volaille'   => (float)$pourcentageVolaille,
            ]);

            session()->setFlashdata('success', 'Régime mis à jour avec succès !');
            return redirect()->to('/regimes');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * GET /regimes/{id}/delete
     * Delete a regime (confirmation, then redirect to destroy)
     */
    public function delete($regimeId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$regimeId) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);

        if (!$regime) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        return view('pages/regimes/delete', [
            'regime' => $regime,
        ]);
    }

    /**
     * POST /regimes/{id}/destroy
     * Actually delete the regime
     */
    public function destroy($regimeId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$regimeId) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);

        if (!$regime) {
            session()->setFlashdata('error', 'Régime non trouvé.');
            return redirect()->to('/regimes');
        }

        try {
            $regimeModel->delete($regimeId);
            session()->setFlashdata('success', 'Régime supprimé avec succès !');
            return redirect()->to('/regimes');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erreur lors de la suppression : ' . $e->getMessage());
            return redirect()->to('/regimes');
        }
    }
}

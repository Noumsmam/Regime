<?php

namespace App\Controllers;

use App\Models\ActivityModel;

class ActivitiesController extends BaseController
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
        return $this->currentUserId() !== null;
    }

    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $activityModel = new ActivityModel();

        return view('pages/activities/index', [
            'title' => 'EtuNote — Activités sportives',
            'pageTitle' => 'Gestion des activités sportives',
            'activeMenu' => 'activities',
            'activities' => $activityModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        return view('pages/activities/create', [
            'title' => 'EtuNote — Créer une activité',
            'pageTitle' => 'Créer une activité sportive',
            'activeMenu' => 'activities',
        ]);
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $name = trim((string) $this->request->getPost('name'));
        $caloriesBurnPerHour = $this->request->getPost('calories_burn_per_hour');
        $intensity = trim((string) $this->request->getPost('intensity'));

        if ($name === '' || $caloriesBurnPerHour === null || $caloriesBurnPerHour === '' || $intensity === '') {
            session()->setFlashdata('error', 'Tous les champs obligatoires doivent être renseignés.');
            return redirect()->back()->withInput();
        }

        if (!is_numeric($caloriesBurnPerHour) || (int) $caloriesBurnPerHour <= 0) {
            session()->setFlashdata('error', 'Les calories brûlées par heure doivent être un nombre positif.');
            return redirect()->back()->withInput();
        }

        if (!in_array($intensity, ['low', 'medium', 'high'], true)) {
            session()->setFlashdata('error', 'L’intensité sélectionnée est invalide.');
            return redirect()->back()->withInput();
        }

        try {
            $activityModel = new ActivityModel();
            $activityModel->insert([
                'name' => $name,
                'calories_burn_per_hour' => (int) $caloriesBurnPerHour,
                'intensity' => $intensity,
            ]);

            session()->setFlashdata('success', 'Activité créée avec succès !');
            return redirect()->to('/activities');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la création de l’activité : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($activityId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$activityId) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->find($activityId);

        if (!$activity) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        return view('pages/activities/edit', [
            'title' => 'EtuNote — Modifier une activité',
            'pageTitle' => 'Modifier une activité sportive',
            'activeMenu' => 'activities',
            'activity' => $activity,
        ]);
    }

    public function update($activityId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$activityId) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->find($activityId);

        if (!$activity) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        $name = trim((string) $this->request->getPost('name'));
        $caloriesBurnPerHour = $this->request->getPost('calories_burn_per_hour');
        $intensity = trim((string) $this->request->getPost('intensity'));

        if ($name === '' || $caloriesBurnPerHour === null || $caloriesBurnPerHour === '' || $intensity === '') {
            session()->setFlashdata('error', 'Tous les champs obligatoires doivent être renseignés.');
            return redirect()->back()->withInput();
        }

        if (!is_numeric($caloriesBurnPerHour) || (int) $caloriesBurnPerHour <= 0) {
            session()->setFlashdata('error', 'Les calories brûlées par heure doivent être un nombre positif.');
            return redirect()->back()->withInput();
        }

        if (!in_array($intensity, ['low', 'medium', 'high'], true)) {
            session()->setFlashdata('error', 'L’intensité sélectionnée est invalide.');
            return redirect()->back()->withInput();
        }

        try {
            $activityModel->update($activityId, [
                'name' => $name,
                'calories_burn_per_hour' => (int) $caloriesBurnPerHour,
                'intensity' => $intensity,
            ]);

            session()->setFlashdata('success', 'Activité mise à jour avec succès !');
            return redirect()->to('/activities');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la mise à jour de l’activité : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($activityId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$activityId) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->find($activityId);

        if (!$activity) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        return view('pages/activities/delete', [
            'title' => 'EtuNote — Supprimer une activité',
            'pageTitle' => 'Supprimer une activité sportive',
            'activeMenu' => 'activities',
            'activity' => $activity,
        ]);
    }

    public function destroy($activityId = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$activityId) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        $activityModel = new ActivityModel();
        $activity = $activityModel->find($activityId);

        if (!$activity) {
            session()->setFlashdata('error', 'Activité non trouvée.');
            return redirect()->to('/activities');
        }

        try {
            $activityModel->delete($activityId);

            session()->setFlashdata('success', 'Activité supprimée avec succès !');
            return redirect()->to('/activities');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la suppression de l’activité : ' . $e->getMessage());
            return redirect()->to('/activities');
        }
    }
}
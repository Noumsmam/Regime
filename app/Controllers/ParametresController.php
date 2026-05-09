<?php

namespace App\Controllers;

use App\Models\OptionModel;

class ParametresController extends BaseController
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

        $optionModel = new OptionModel();

        return view('pages/parametres/index', [
            'title' => 'EtuNote — Paramètres',
            'pageTitle' => 'Gestion des paramètres',
            'activeMenu' => 'parametres',
            'parametres' => $optionModel->orderBy('categorie', 'ASC')->orderBy('nom', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        return view('pages/parametres/create', [
            'title' => 'EtuNote — Créer un paramètre',
            'pageTitle' => 'Créer un paramètre',
            'activeMenu' => 'parametres',
        ]);
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        $nom = trim((string) $this->request->getPost('nom'));
        $valeur = trim((string) $this->request->getPost('valeur'));
        $categorie = trim((string) $this->request->getPost('categorie'));
        $description = trim((string) $this->request->getPost('description'));
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if ($nom === '' || $valeur === '') {
            session()->setFlashdata('error', 'Le nom et la valeur sont obligatoires.');
            return redirect()->back()->withInput();
        }

        try {
            $optionModel = new OptionModel();
            $optionModel->insert([
                'nom' => $nom,
                'valeur' => $valeur,
                'categorie' => $categorie !== '' ? $categorie : null,
                'description' => $description !== '' ? $description : null,
                'is_active' => $isActive,
            ]);

            session()->setFlashdata('success', 'Paramètre créé avec succès !');
            return redirect()->to('/parametres');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la création du paramètre : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$id) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        $optionModel = new OptionModel();
        $parametre = $optionModel->find($id);

        if (!$parametre) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        return view('pages/parametres/edit', [
            'title' => 'EtuNote — Modifier un paramètre',
            'pageTitle' => 'Modifier un paramètre',
            'activeMenu' => 'parametres',
            'parametre' => $parametre,
        ]);
    }

    public function update($id = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$id) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        $optionModel = new OptionModel();
        $parametre = $optionModel->find($id);

        if (!$parametre) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        $nom = trim((string) $this->request->getPost('nom'));
        $valeur = trim((string) $this->request->getPost('valeur'));
        $categorie = trim((string) $this->request->getPost('categorie'));
        $description = trim((string) $this->request->getPost('description'));
        $isActive = $this->request->getPost('is_active') ? 1 : 0;

        if ($nom === '' || $valeur === '') {
            session()->setFlashdata('error', 'Le nom et la valeur sont obligatoires.');
            return redirect()->back()->withInput();
        }

        try {
            $optionModel->update($id, [
                'nom' => $nom,
                'valeur' => $valeur,
                'categorie' => $categorie !== '' ? $categorie : null,
                'description' => $description !== '' ? $description : null,
                'is_active' => $isActive,
            ]);

            session()->setFlashdata('success', 'Paramètre mis à jour avec succès !');
            return redirect()->to('/parametres');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la mise à jour du paramètre : ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$id) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        $optionModel = new OptionModel();
        $parametre = $optionModel->find($id);

        if (!$parametre) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        return view('pages/parametres/delete', [
            'title' => 'EtuNote — Supprimer un paramètre',
            'pageTitle' => 'Supprimer un paramètre',
            'activeMenu' => 'parametres',
            'parametre' => $parametre,
        ]);
    }

    public function destroy($id = null)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login');
        }

        if (!$id) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        $optionModel = new OptionModel();
        $parametre = $optionModel->find($id);

        if (!$parametre) {
            session()->setFlashdata('error', 'Paramètre non trouvé.');
            return redirect()->to('/parametres');
        }

        try {
            $optionModel->delete($id);
            session()->setFlashdata('success', 'Paramètre supprimé avec succès !');
            return redirect()->to('/parametres');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Erreur lors de la suppression du paramètre : ' . $e->getMessage());
            return redirect()->to('/parametres');
        }
    }
}
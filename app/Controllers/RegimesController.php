<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\UserRegimePurchaseModel;
use App\Models\WalletModel;
use App\Services\DiscountService;

class RegimesController extends BaseController
{
    private function normalizeDurationDays($duration): int
    {
        $days = is_numeric($duration) ? (int) $duration : 30;

        if ($days < 7) {
            return 7;
        }

        if ($days > 365) {
            return 365;
        }

        return $days;
    }

    private function computeDurationPrice(float $basePrice, int $durationDays): float
    {
        return round($basePrice * ($durationDays / 30), 2);
    }

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

    private function normalizeRegimePrices(array $regimes): array
    {
        foreach ($regimes as &$regime) {
            $regimeName = isset($regime['name']) && is_string($regime['name']) ? $regime['name'] : null;

            if (!isset($regime['price']) || $regime['price'] === null || $regime['price'] === '') {
                $regime['price'] = $this->getDefaultRegimePrice($regimeName);
            }
        }

        return $regimes;
    }

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

        $userId = $this->currentUserId();
        $regimeModel = new RegimeModel();
        $discountService = new DiscountService();

        $regimes = $this->normalizeRegimePrices($regimeModel->findAll());
        
        // Ajouter les infos de remise pour chaque régime
        $discount = $discountService->getDiscountPercentage($userId);
        $userOptions = $discountService->getUserOptions($userId);

        return view('pages/regimes/index', [
            'regimes' => $regimes,
            'discount' => $discount,
            'userOptions' => $userOptions,
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

    /**
     * POST /regimes/{id}/buy
     * Buy a regime plan
     */
    public function buyRegime($regimeId)
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        if (!$regimeId) {
            return redirect()->back()->with('error', 'Régime non trouvé.');
        }

        $regimeModel = new RegimeModel();
        $purchaseModel = new UserRegimePurchaseModel();
        $discountService = new DiscountService();
        $walletModel = new WalletModel();
        $db = db_connect();

        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->back()->with('error', 'Régime non trouvé.');
        }

        $durationDays = $this->normalizeDurationDays($this->request->getPost('duration_days'));

        // Vérifier si le prix existe, avec prix par défaut pour les régimes connus
        $regimeName = isset($regime['name']) && is_string($regime['name']) ? $regime['name'] : null;
        $regime['price'] = $regime['price'] ?? $this->getDefaultRegimePrice($regimeName);
        if (!isset($regime['price']) || $regime['price'] === null) {
            return redirect()->back()->with('error', 'Ce régime n\'est pas disponible à l\'achat.');
        }

        $basePrice = (float) $regime['price'];
        $priceForDuration = $this->computeDurationPrice($basePrice, $durationDays);

        // Vérifier si l'utilisateur a déjà acheté ce régime
        if ($purchaseModel->hasPurchased($userId, $regimeId)) {
            return redirect()->back()->with('info', 'Vous avez déjà acheté ce régime.');
        }

        // Vérifier le solde du portefeuille depuis la table wallets
        $wallet = $walletModel->getOrCreateByUserId($userId);

        // Calculer le prix avec remise si l'utilisateur a une option Gold
        $discountPercentage = $discountService->getDiscountPercentage($userId);
        $finalPrice = round($discountService->applyDiscount($priceForDuration, $discountPercentage), 2);

        if ($wallet['balance'] < $finalPrice) {
            $needed = number_format($finalPrice, 2, ',', ' ');
            $have = number_format($wallet['balance'], 2, ',', ' ');
            return redirect()->back()->with('error', 
                'Solde insuffisant. Prix : ' . $needed . '€ (vous avez ' . $have . '€)');
        }

        try {
            $db->transStart();

            // Débiter du portefeuille
            $walletModel->update($wallet['id'], [
                'balance' => $wallet['balance'] - $finalPrice
            ]);

            // Enregistrer l'achat
            $purchaseModel->insert([
                'user_id' => $userId,
                'regime_id' => $regimeId,
                'price_paid' => $finalPrice,
                'discount_applied' => $discountPercentage,
                'duration_days' => $durationDays,
                'purchased_at' => date('Y-m-d H:i:s')
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Erreur lors de l\'achat du régime.');
            }

            $discountMsg = $discountPercentage > 0 ? 
                ' (Remise de ' . $discountPercentage . '% appliquée)' : '';
            
            return redirect()->back()->with('success', 
                'Régime "' . $regime['name'] . '" acheté avec succès ! ' . 
                number_format($finalPrice, 2, ',', ' ') . '€ débité pour ' . $durationDays . ' jours.' . $discountMsg);

        } catch (\Exception $e) {
            log_message('error', '[Regimes] Purchase error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'achat.');
        }
    }
}

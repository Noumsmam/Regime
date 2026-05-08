<?php

namespace App\Controllers;

use App\Models\OffreModel;
use App\Models\WalletModel;

class OffresController extends BaseController
{
    protected $offreModel;
    protected $walletModel;

    public function __construct()
    {
        $this->offreModel = new OffreModel();
        $this->walletModel = new WalletModel();
    }

    /**
     * Affiche les options disponibles à l'achat
     */
    public function index()
    {
        $userId = session('user')['id'] ?? null;
        if (!$userId) {
            return redirect()->to('/login');
        }

        try {
            $offres = $this->offreModel->getPaidOffres();
            
            // Récupérer les offres actuelles de l'utilisateur
            $db = db_connect();
            $userOffres = $db->table('userOffre')
                ->select('userOffre.id_offre, offre.libelle')
                ->join('offre', 'offre.id = userOffre.id_offre')
                ->where('userOffre.id_user', $userId)
                ->get()
                ->getResultArray();

            $userOffreIds = array_column($userOffres, 'id_offre');

            // Récupérer le solde du portefeuille depuis la table wallets
            $wallet = $this->walletModel->getOrCreateByUserId($userId);
            $walletBalance = $wallet['balance'] ?? 0;

            return view('offres/index', [
                'offres' => $offres,
                'userOffreIds' => $userOffreIds,
                'userOffres' => $userOffres,
                'walletBalance' => $walletBalance
            ]);
        } catch (\Exception $e) {
            log_message('error', '[Offres] Index error: ' . $e->getMessage());
            return view('offres/index', [
                'offres' => [],
                'userOffreIds' => [],
                'userOffres' => [],
                'walletBalance' => 0,
                'error' => 'La page des options premium est temporairement indisponible. Veuillez réappliquer les migrations.'
            ]);
        }
    }

    /**
     * Achète une option (simule un achat simple)
     */
    public function buy($offreId)
    {
        $userId = session('user')['id'] ?? null;
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $offre = $this->offreModel->find($offreId);
        if (!$offre) {
            return redirect()->back()->with('error', 'Option non trouvée.');
        }

        if (($offre['libelle'] ?? '') === 'Gold' && (!isset($offre['price']) || $offre['price'] === null || $offre['price'] === '')) {
            $offre['price'] = 9.99;
        }

        if ($offre['price'] === null) {
            return redirect()->back()->with('error', 'Cette option ne peut pas être achetée.');
        }

        $db = db_connect();
        
        // Vérifier si l'utilisateur a déjà cette offre
        $exists = $db->table('userOffre')
            ->where('id_user', $userId)
            ->where('id_offre', $offreId)
            ->get()
            ->getNumRows();

        if ($exists > 0) {
            return redirect()->back()->with('info', 'Vous avez déjà cette option.');
        }

        // Vérifier le solde du portefeuille
        $wallet = $this->walletModel->getOrCreateByUserId($userId);

        if ($wallet['balance'] < $offre['price']) {
            return redirect()->back()->with('error', 'Solde insuffisant. Vous avez besoin de ' . number_format($offre['price'], 2, ',', ' ') . '€.');
        }

        // Déduire du portefeuille et ajouter l'offre
        try {
            $db->transStart();

            // Déduire du portefeuille
            $this->walletModel->update($wallet['id'], [
                'balance' => $wallet['balance'] - $offre['price']
            ]);

            // Ajouter l'offre à l'utilisateur
            $db->table('userOffre')->insert([
                'id_user' => $userId,
                'id_offre' => $offreId
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Erreur lors de l\'achat.');
            }

            return redirect()->back()->with('success', 
                'Option "' . $offre['libelle'] . '" achetée avec succès ! ' . 
                number_format($offre['price'], 2, ',', ' ') . '€ débité de votre portefeuille.');

        } catch (\Exception $e) {
            log_message('error', '[Offres] Purchase error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'achat.');
        }
    }
}

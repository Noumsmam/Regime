<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WalletModel;
use App\Services\ImcService;

class Pages extends BaseController
{
    public function login(): string
    {
        return view('pages/login', [
            'title' => 'EtuNote — Connexion',
            'useAppLayout' => false,
        ]);
    }

    public function dashboard(): string
    {
        $userSession = session()->get('user');
        $user = null;
        $walletBalance = 0;
        $imc = 0;
        $imcStatus = [
            'category' => 'Unknown',
            'status' => 'Unknown',
            'color' => 'gray',
        ];

        if ($userSession && isset($userSession['id'])) {
            $userModel = new UserModel();
            $user = $userModel->getUserWithInfo($userSession['id']);

            try {
                $walletModel = new WalletModel();
                $wallet = $walletModel->getOrCreateByUserId((int) $userSession['id']);
                $walletBalance = (float) ($wallet['balance'] ?? 0);
            } catch (\Throwable $e) {
                $walletBalance = 0;
            }

            if ($user) {
                $imc = ImcService::calculateImc($user['poids'] ?? 0, $user['taille'] ?? 0);
                $imcStatus = ImcService::getImcStatus($imc);
            }
        }

        return view('pages/dashboard', [
            'title' => 'EtuNote — Tableau de bord',
            'pageTitle' => 'Tableau de bord',
            'activeMenu' => 'dashboard',
            'user' => $user,
            'walletBalance' => $walletBalance,
            'imc' => $imc,
            'imcStatus' => $imcStatus,
        ]);
    }

    public function utilisateurs(): string
    {
        return view('pages/list', [
            'title' => 'EtuNote — Utilisateurs',
            'pageTitle' => 'Gestion des utilisateurs',
            'activeMenu' => 'utilisateurs',
        ]);
    }

    public function formulaire(): string
    {
        return view('pages/form', [
            'title' => 'EtuNote — Formulaire utilisateur',
            'pageTitle' => 'Formulaire utilisateur',
            'activeMenu' => 'formulaire',
        ]);
    }

    public function etudiants(): string
    {
        return view('pages/liste_etudiants', [
            'title' => 'EtuNote - Liste des etudiants',
            'pageTitle' => 'Liste des etudiants',
            'activeMenu' => 'etudiants',
        ]);
    }
}

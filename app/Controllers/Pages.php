<?php

namespace App\Controllers;

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
        return view('pages/dashboard', [
            'title' => 'EtuNote — Tableau de bord',
            'pageTitle' => 'Tableau de bord',
            'activeMenu' => 'dashboard',
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

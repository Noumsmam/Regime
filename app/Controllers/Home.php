<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/login', [
            'title' => 'EtuNote — Connexion',
            'useAppLayout' => false,
        ]);
    }
}

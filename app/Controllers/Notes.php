<?php

namespace App\Controllers;

class Notes extends BaseController
{
    public function ajout(): string
    {
        return view('pages/ajout_note', [
            'title' => 'EtuNote - Ajout note',
            'pageTitle' => 'Ajout note',
            'activeMenu' => 'ajout_note',
        ]);
    }

    public function semestres(): string
    {
        return view('pages/liste_notes_semestre', [
            'title' => 'EtuNote - Notes par semestre',
            'pageTitle' => 'Notes par semestre',
            'activeMenu' => 'notes_semestres',
        ]);
    }

    public function releve(): string
    {
        return view('pages/detail_note', [
            'title' => 'EtuNote - Releve de notes',
            'pageTitle' => 'Releve de notes',
            'activeMenu' => 'notes_semestres',
        ]);
    }
}

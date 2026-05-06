<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'note';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'etudiant_id',
        'matiere_id',
        'option_id',
        'note'
    ];
}
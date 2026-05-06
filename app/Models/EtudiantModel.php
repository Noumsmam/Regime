<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'etudiant';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nom', 
        'prenom', 
        'etudiant_id', 
        'email'
    ];
}
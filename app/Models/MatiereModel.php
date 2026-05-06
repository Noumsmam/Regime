<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'matiere';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nom',
        'credits',
        'etat_id',
        'semestre_id'
    ];
}
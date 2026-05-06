<?php

namespace App\Models;

use CodeIgniter\Model;

class SemestreModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'semestre';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nom'
    ];
}
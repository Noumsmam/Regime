<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'options';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nom'
    ];
}
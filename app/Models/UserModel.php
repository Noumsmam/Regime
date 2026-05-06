<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'user';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'username', 
        'password'
    ];
}
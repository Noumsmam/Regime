<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'email',
        'username',
        'password',
        'id_genre'
    ];
}
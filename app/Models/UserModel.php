<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // 4.1 Déclaration de la table et des champs autorisés
    protected $table            = 'user';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nom',
        'email',
        'password',
        'genre',
        'taille',
        'poids',
        'objectif',
        'gold_option',
        'portefeuille',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
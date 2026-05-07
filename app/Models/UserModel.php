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

    /**
     * Get user with their health info (taille, poids)
     * 
     * @param int $userId User ID
     * @return array|null User data with taille and poids from userInfo
     */
    public function getUserWithInfo($userId)
    {
        $user = $this->find($userId);
        if (!$user) {
            return null;
        }

        $db = db_connect();
        $userInfo = $db->table('userInfo')
                       ->where('id_user', $userId)
                       ->get()
                       ->getRowArray();

        if ($userInfo) {
            $user['taille'] = $userInfo['taille'] ?? 0;
            $user['poids'] = $userInfo['poids'] ?? 0;
        } else {
            $user['taille'] = 0;
            $user['poids'] = 0;
        }

        return $user;
    }
}
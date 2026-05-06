<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
 	public function login()
 	{
 		$model = new UserModel();
 		$email = $this->request->getPost('username');
 		$password = $this->request->getPost('password');
 		$user = $model->where('username', $email)->first();
 		if (!$user || $password !== $user['password']) {
 			return redirect()->to('/')->with('erreur', 'Identifiants invalides');
 		}
 		// Stocker uniquement les données non sensibles en session
 		session()->set('user', [
 			'id' => $user['id'],
 			'nom' => $user['username'],
 			// 'admin' | 'bibliothecaire' | 'lecteur'
 		]);
 		return redirect()->to('/etudiants');
 	}

 	public function logout()
 	{
 		session()->destroy();
 		return redirect()->to('/');
 	}
 }
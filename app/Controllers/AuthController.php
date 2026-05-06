<?php
namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Affiche le formulaire d'inscription (page 1 : infos utilisateur)
     */
    public function registerStep1()
    {
        return view('auth/register_step1');
    }

    /**
     * Valide les données de l'étape 1 et passe à l'étape 2
     */
    public function registerStep1Post()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'nom' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'genre' => 'required|in_list[M,F,Autre]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Stocker temporairement les données en session
        session()->set('register_step1', [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'genre' => $this->request->getPost('genre'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/register/step2');
    }

    /**
     * Affiche le formulaire d'inscription (page 2 : infos santé)
     */
    public function registerStep2()
    {
        if (!session()->has('register_step1')) {
            return redirect()->to('/register');
        }
        return view('auth/register_step2');
    }

    /**
     * Complète l'inscription avec les infos santé et crée l'utilisateur
     */
    public function registerStep2Post()
    {
        if (!session()->has('register_step1')) {
            return redirect()->to('/register');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'taille' => 'required|numeric|greater_than[0]',
            'poids' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $db = db_connect();
        $userModel = new UserModel();
        $registerData = session()->get('register_step1');

        $genreRow = $db->table('genre')
            ->where('libelle', $registerData['genre'])
            ->get()
            ->getFirstRow('array');

        if (!$genreRow) {
            $db->table('genre')->insert(['libelle' => $registerData['genre']]);
            $genreId = $db->insertID();
        } else {
            $genreId = $genreRow['id'];
        }

        $db->transStart();

        $userId = $userModel->insert([
            'email' => $registerData['email'],
            'username' => $registerData['nom'],
            'password' => $registerData['password'],
            'id_genre' => $genreId,
        ], true);

        if ($userId) {
            $db->table('userInfo')->insert([
                'id_user' => $userId,
                'taille' => $this->request->getPost('taille'),
                'poids' => $this->request->getPost('poids'),
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erreur lors de l\'inscription.');
        }

        session()->remove('register_step1');
        return redirect()->to('/')->with('success', 'Inscription réussie ! Connectez-vous.');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function loginForm()
    {
        return view('auth/login');
    }

    /**
     * Traite la connexion
     */
    public function login()
    {
        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $validation = \Config\Services::validation();
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $user = $model->where('email', $email)->first();
        
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        $genreRow = db_connect()->table('genre')->where('id', $user['id_genre'])->get()->getFirstRow('array');

        // Stocker les données non sensibles en session
        session()->set('user', [
            'id' => $user['id'],
            'nom' => $user['username'],
            'email' => $user['email'],
            'genre' => $genreRow['libelle'] ?? null,
        ]);

        return redirect()->to('/dashboard');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
 }
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes publiques (pas besoin de login)
$routes->get('/', 'Home::index');
$routes->get('/register', 'AuthController::registerStep1');
$routes->post('/register', 'AuthController::registerStep1Post');
$routes->get('/register/step2', 'AuthController::registerStep2');
$routes->post('/register/step2', 'AuthController::registerStep2Post');
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');

// Routes protégées (nécessitent une authentification)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/deconnexion', 'AuthController::logout');
    $routes->get('/dashboard', 'Pages::dashboard');
    $routes->get('/utilisateurs', 'Pages::utilisateurs');
});


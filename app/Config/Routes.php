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
    
    // Goals routes
    $routes->get('/goals', 'GoalsController::index');
    $routes->get('/goals/create', 'GoalsController::create');
    $routes->post('/goals/store', 'GoalsController::store');
    $routes->get('/goals/(:num)/activate', 'GoalsController::activate/$1');
    $routes->get('/goals/(:num)/complete', 'GoalsController::complete/$1');
    $routes->get('/goals/(:num)/plan', 'GoalsController::showPlan/$1');

    // Regimes routes (CRUD)
    $routes->get('/regimes', 'RegimesController::index');
    $routes->get('/regimes/create', 'RegimesController::create');
    $routes->post('/regimes/store', 'RegimesController::store');
    $routes->get('/regimes/(:num)/edit', 'RegimesController::edit/$1');
    $routes->post('/regimes/(:num)/update', 'RegimesController::update/$1');
    $routes->get('/regimes/(:num)/delete', 'RegimesController::delete/$1');
    $routes->post('/regimes/(:num)/destroy', 'RegimesController::destroy/$1');
    $routes->post('/regimes/(:num)/buy', 'RegimesController::buyRegime/$1');

    // Wallet / coupons routes
    $routes->get('/wallet', 'WalletController::index');
    $routes->post('/wallet/redeem', 'WalletController::redeemCoupon');

    // Options (offres) routes
    $routes->get('/offres', 'OffresController::index');
    $routes->post('/offres/buy/(:num)', 'OffresController::buy/$1');
});


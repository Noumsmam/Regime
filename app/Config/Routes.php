<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/login', 'AuthController::login');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/deconnexion', 'AuthController::logout');
    $routes->get('/dashboard', 'Pages::dashboard');
    $routes->get('/utilisateurs', 'Pages::utilisateurs');
    $routes->get('/formulaire', 'Pages::formulaire');
    $routes->get('/etudiants', 'Pages::etudiants');
    $routes->get('/notes/ajout', 'Notes::ajout');
    $routes->get('/notes/semestres', 'Notes::semestres');
    $routes->get('/notes/releve', 'Notes::releve');
});
// Core pages



// Notes and students

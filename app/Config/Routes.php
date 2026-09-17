<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Routes d'authentification
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);

// Routes utilisateur connecté
$routes->group('', ['filter' => 'session'], function($routes) {
    // Cantina
    $routes->group('cantina', function($routes) {
        $routes->get('/', 'CantinaController::index');
        $routes->post('refresh', 'CantinaController::refresh');
        $routes->post('recruit/(:num)', 'CantinaController::recruit/$1');
    });

    // Équipage
    $routes->group('equipage', function ($routes) {
        $routes->get('/', 'CrewController::index');
        $routes->post('sell/(:num)', 'CrewController::sell/$1');
    });
});

// Routes d'administration
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function ($routes) {

    $routes->get('/', 'AdminController::index');

    // Gestion des utilisateurs
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('new', 'UserController::new');
        $routes->post('create', 'UserController::create');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1'); // ID passé dans la route pour plus de clarté
    });

    // Seuils de niveau
    $routes->group('level-threshold', function ($routes) {
        $routes->get('/', 'LevelThresholdController::index');
        $routes->post('create', 'LevelThresholdController::create');
        $routes->post('update', 'LevelThresholdController::update');
        $routes->post('delete', 'LevelThresholdController::delete');
    });

    // Niveaux de rareté
    $routes->group('rarity-level', function ($routes) {
        $routes->get('/', 'RarityLevelController::index');
        $routes->post('create', 'RarityLevelController::create');
        $routes->post('update', 'RarityLevelController::update');
        $routes->post('delete', 'RarityLevelController::delete');
    });

    // Spécialisations
    $routes->group('specialization-level', function ($routes) {
        $routes->get('/', 'SpecializationLevelController::index');
        $routes->post('create', 'SpecializationLevelController::create');
        $routes->post('update', 'SpecializationLevelController::update');
        $routes->post('delete', 'SpecializationLevelController::delete');
    });

    // Modèles de héros
    $routes->group('hero-model', function ($routes) {
        $routes->get('/', 'HeroModelController::index');
        $routes->get('new', 'HeroModelController::new');
        $routes->get('edit/(:num)', 'HeroModelController::edit/$1');
        $routes->post('create-update', 'HeroModelController::createUpdate');
        $routes->post('delete/(:num)', 'HeroModelController::delete/$1'); // Passage en POST pour la sécurité
    });
});
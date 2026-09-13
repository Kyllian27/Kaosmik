<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Routes pour l'authentification
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);

// Routes pour l'utilisateur connecté
$routes->group('', ['filter' => 'session'], function ($routes) {
    $routes->group('cantina', function ($routes) {
        $routes->get('/', 'CantinaController::index');
    });
});

// Routes pour l'administration
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');

    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->get('new', 'UserController::new');
        $routes->post('update', 'UserController::update');
        $routes->post('create', 'UserController::create');
    });

    $routes->group('level-threshold', function ($routes) {
        $routes->get('/', 'LevelThresholdController::index');
        $routes->post('update', 'LevelThresholdController::update');
        $routes->post('create', 'LevelThresholdController::create');
        $routes->post('delete', 'LevelThresholdController::delete');
    });

    $routes->group('rarity-level', function ($routes) {
        $routes->get('/', 'RarityLevelController::index');
        $routes->post('update', 'RarityLevelController::update');
        $routes->post('create', 'RarityLevelController::create');
        $routes->post('delete', 'RarityLevelController::delete');
    });

    $routes->group('hero-model', function ($routes) {
        $routes->get('/', 'HeroModelController::index');
        $routes->get('new', 'HeroModelController::new');
        $routes->get('edit/(:num)', 'HeroModelController::edit/$1');
        $routes->post('create-update', 'HeroModelController::createUpdate');
        $routes->post('delete', 'HeroModelController::delete');
    });

    $routes->group('specialization', function ($routes) {
        $routes->get('/', 'SpecializationController::index');
        $routes->get('new', 'SpecializationController::new');
        $routes->get('edit/(:num)', 'SpecializationController::edit/$1');
        $routes->post('create-update', 'SpecializationController::createUpdate');
        $routes->post('delete', 'SpecializationController::delete');
    });

    $routes->group('specialization-level', function ($routes) {
        $routes->get('/', 'SpecializationLevelController::index');
        $routes->post('create', 'SpecializationLevelController::create');
        $routes->post('update', 'SpecializationLevelController::update');
        $routes->post('delete', 'SpecializationLevelController::delete');
    });
});
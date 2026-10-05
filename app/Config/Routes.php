<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

//Routes pour l'authentification
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);

//Routes pour l'utilisateur connecté
$routes->group('', ['filter' => 'session'], function($routes) {
    //Routes pour la cantina
    $routes->group('cantina', function($routes) {
       $routes->get('/', 'CantinaController::index');
       $routes->post('refresh', 'CantinaController::refresh');
       $routes->post('recruit/(:num)', 'CantinaController::recruit/$1');
    });
    //Routes pour l'équipage
    $routes->group('equipage', function($routes) {
       $routes->get('/', 'CrewController::index');
       $routes->post('sell/(:num)', 'CrewController::sell/$1');
       $routes->post('sell-bulk', 'CrewController::sellBulk');
    });
    //Routes pour les missions
    $routes->group('mission', function($routes) {
       $routes->get('/', 'MissionController::index');
       $routes->get('details/(:num)', 'MissionController::details/$1');
       $routes->post('envoyer-l-equipage', 'MissionController::sendCrew');
       $routes->post('send-crew', 'MissionController::validateMission');
       $routes->get('resultats', 'MissionController::results');
    });
    //Routes pour le profil
    $routes->group('mon-profil', function($routes) {
        $routes->get('mes-anciennes-missions', 'UserController::oldMissions');
    });
});

//Routes pour l'administration
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

    $routes->group('specialization', function ($routes) {
        $routes->get('/', 'SpecializationController::index');
        $routes->post('update', 'SpecializationController::update');
        $routes->post('create', 'SpecializationController::create');
        $routes->post('delete', 'SpecializationController::delete');
    });

    $routes->group('hero-model', function ($routes) {
        $routes->get('/', 'HeroModelController::index');
        $routes->get('new', 'HeroModelController::new');
        $routes->get('edit/(:num)', 'HeroModelController::edit/$1');
        $routes->post('create-update', 'HeroModelController::createUpdate');
        $routes->get('delete/(:num)', 'HeroModelController::delete/$1');
    });

    $routes->group('mission', function ($routes) {
        $routes->get('/', 'MissionController::index');
        $routes->get('new', 'MissionController::new');
        $routes->get('edit/(:num)', 'MissionController::edit/$1');
        $routes->post('create-update', 'MissionController::createUpdate');
        $routes->get('delete/(:num)', 'MissionController::delete/$1');
    });
});
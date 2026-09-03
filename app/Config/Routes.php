<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', [AuthController::class, 'loginView']);
$routes->post('login', [AuthController::class, 'loginAction']);
$routes->get('register', [AuthController::class, 'registerView']);
$routes->post('register', [AuthController::class, 'registerAction']);
$routes->get('logout', [AuthController::class, 'logoutAction']);

// Routes pour l'administration
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');

    // Alias et redirections pour capturer les variantes au singulier / pluriel et erreurs de frappe
    $routes->get('level_threshold', 'LevelThresholdController::index');
    $routes->get('level_thresholde', 'LevelThresholdController::index');
    $routes->get('level_thresholds', 'LevelThresholdController::index');
    $routes->get('level_thresholdertable', 'LevelThresholdController::index');
    $routes->get('level_thresholderTable', 'LevelThresholdController::index');
    $routes->get('level_thresholdtable', 'LevelThresholdController::index');

    // Gestion des utilisateurs
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('new', 'UserController::new');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->get('delete/(:num)', 'UserController::delete/$1');
        $routes->post('create', 'UserController::create');
        $routes->post('update', 'UserController::update');
    });

    // Gestion des seuils de niveau (Level Thresholds)
    $routes->group('level-threshold', function ($routes) {
        $routes->get('/', 'LevelThresholdController::index');
        $routes->post('create', 'LevelThresholdController::create');
        $routes->post('update', 'LevelThresholdController::update');
        $routes->post('delete', 'LevelThresholdController::delete');
    });
});
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
service('auth')->routes($routes, ['except' => ['login', 'register']]);
$routes->get('register', 'Authentication\RegisterController::registerView');
$routes->post('register', 'Authentication\RegisterController::registerAction',['as' => 'register']);
$routes->get('login', 'Authentication\LoginController::loginView');
$routes->post('login', 'Authentication\LoginController::loginAction');
$routes->get('dashboard', 'Home::dashboard');
$routes->get('add-product', 'Products\ProductsController::addProduct', ['as' => 'addProduct']);
$routes->post('save-prod-detail', 'Products\ProductsController::saveProdDetail', ['as' => 'saveProdDetail']);






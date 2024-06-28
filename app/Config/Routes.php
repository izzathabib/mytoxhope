<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
service('auth')->routes($routes, ['except' => ['register']]);
$routes->get('register', 'Authentication\RegisterController::index');
$routes->get('check-Register', 'Authentication\RegisterController::checkRegister',['as' => 'checkRegister']);

$routes->post('check-Register', 'Authentication\RegisterController::checkRegister',['as' => 'checkRegister']);
$routes->get('dashboard', 'Home::dashboard');
$routes->get('add-product', 'Products\ProductsController::addProduct', ['as' => 'addProduct']);
$routes->post('save-prod-detail', 'Products\ProductsController::saveProdDetail', ['as' => 'saveProdDetail']);





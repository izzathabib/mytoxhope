<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
service('auth')->routes($routes);
$routes->get('dashboard', 'Home::dashboard');
$routes->get('add-product', 'Products\ProductsController::addProduct', ['as' => 'addProduct']);




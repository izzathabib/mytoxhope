<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
service('auth')->routes($routes);
$routes->get('dashboard', 'Home::dashboard');
$routes->get('add-product/(:any)', 'Products\ProductsController::addProduct/$1', ['as' => 'addProduct']);
$routes->post('save-prod-detail', 'Products\ProductsController::saveProdDetail', ['as' => 'saveProdDetail']);





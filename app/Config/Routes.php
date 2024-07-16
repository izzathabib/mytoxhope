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
$routes->get('list-product', 'Products\ProductsController::productList', ['as' => 'productList']);
$routes->post('save-prod-detail', 'Products\ProductsController::saveProdDetail', ['as' => 'saveProdDetail']);
$routes->get('display-prod-detail/(:num)', 'Products\ProductsController::displayProdDetail/$1', ['as' => 'displayProdDetail']);
$routes->get('product-update/(:num)', 'Products\ProductsController::productUpdate/$1', ['as' => 'productUpdate']);
$routes->post('save-update-detail/(:num)', 'Products\ProductsController::saveUpdateDetail/$1', ['as' => 'saveUpdateDetail']);
$routes->get('display-prod-discontinue/(:num)', 'Products\ProductsController::displayProdDiscontinue/$1', ['as' => 'productDiscontinue']);







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
$routes->get('forgot-password', 'Authentication\LoginController::forgotPass', ['as' => 'forgotPass']);
$routes->post('sent-passcode', 'Authentication\LoginController::sentPasscode', ['as' => 'sentPasscode']);

$routes->get('dashboard', 'Home::dashboard');

$routes->get('add-product', 'Products\ProductsController::addProduct', ['as' => 'addProduct']);
$routes->get('list-product', 'Products\ProductsController::productList', ['as' => 'productList']);
$routes->post('save-prod-detail', 'Products\ProductsController::saveProdDetail', ['as' => 'saveProdDetail']);
$routes->get('display-prod-detail/(:num)', 'Products\ProductsController::displayProdDetail/$1', ['as' => 'displayProdDetail']);
$routes->get('product-update/(:num)', 'Products\ProductsController::productUpdate/$1', ['as' => 'productUpdate']);
$routes->post('save-update-detail/(:num)', 'Products\ProductsController::saveUpdateDetail/$1', ['as' => 'saveUpdateDetail']);
$routes->get('product-discontinue/(:num)', 'Products\ProductsController::productDiscontinue/$1', ['as' => 'productDiscontinue']);
$routes->post('product-delete/(:num)', 'Products\ProductsController::productDelete/$1', ['as' => 'productDelete']);
$routes->get('display-prod-disconDelete/(:num)', 'Products\ProductsController::displayDisconDeleteProd/$1', ['as' => 'displayDisconDeleteProd']);
$routes->get('approve-delete/(:num)', 'Products\ProductsController::approveDelete/$1', ['as' => 'approveDelete']);
$routes->get('reject-delete/(:num)', 'Products\ProductsController::rejectDelete/$1', ['as' => 'rejectDelete']);
$routes->get('delete-product-list', 'Products\ProductsController::productDeleteList', ['as' => 'productDeleteList']);
$routes->post('delete-product-permanently/(:num)', 'Products\ProductsController::delProdPermanent/$1', ['as' => 'delProdPermanent']);
$routes->get('activate-product/(:num)', 'Products\ProductsController::activateProd/$1', ['as' => 'activateProd']);

// Delete request
$routes->get('delete-request-list', 'Products\ProductsController::deleteRequestList', ['as' => 'deleteRequestList']);










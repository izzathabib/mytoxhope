<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register-company', 'Home::register', ['as' => 'register']);

$routes->get('dashboard', 'Home::dashboard');


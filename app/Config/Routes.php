<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::dashboard');
service('auth')->routes($routes);


$routes->get('dashboard', 'Home::dashboard');



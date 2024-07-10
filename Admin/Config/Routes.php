<?php

namespace Admin\Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('Admin/users', '\Admin\Controllers\Users::index',['as' => 'viewUser']);
 $routes->post('verify-user/(:num)', '\Admin\Controllers\Users::verifyUser/$1',['as' => 'verifyUser']);

 

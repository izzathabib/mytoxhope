<?php

namespace Admin\Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('Admin/users', '\Admin\Controllers\Users::index',['as' => 'viewUser']);
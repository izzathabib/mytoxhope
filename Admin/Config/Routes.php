<?php

namespace Admin\Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('Admin/users', '\Admin\Controllers\Users::index',['as' => 'viewUser']);
 $routes->post('verify-user/(:num)', '\Admin\Controllers\Users::verifyUser/$1',['as' => 'verifyUser']);
 $routes->get('add-new-user', '\Admin\Controllers\Users::addNewUser',['as' => 'addNewUser']);
 $routes->post('save-user', '\Admin\Controllers\Users::saveUser',['as' => 'saveUser']);
 $routes->get('edit-user/(:num)', '\Admin\Controllers\Users::editUser/$1',['as' => 'editUser']);
 $routes->post('save-edit-user/(:num)', '\Admin\Controllers\Users::saveEditUser/$1',['as' => 'saveEditUser']);
 $routes->post('delete-user/(:num)', '\Admin\Controllers\Users::deleteUser/$1',['as' => 'deleteUser']);

 $routes->get('Admin/company', '\Admin\Controllers\CompanyController::index',['as' => 'viewCompany']);


 

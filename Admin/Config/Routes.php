<?php

namespace Admin\Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('Admin/users', '\Admin\Controllers\Users::index',['as' => 'viewUser']);
 $routes->get('view-verify-request', '\Admin\Controllers\Users::viewVerifyRequest',['as' => 'viewVerifyRequest']);

 $routes->post('verify-user/(:num)', '\Admin\Controllers\Users::verifyUser/$1',['as' => 'verifyUser']);
 $routes->get('add-new-user', '\Admin\Controllers\Users::addNewUser',['as' => 'addNewUser']);
 $routes->post('save-user', '\Admin\Controllers\Users::saveUser',['as' => 'saveUser']);
 $routes->get('edit-user/(:num)', '\Admin\Controllers\Users::editUser/$1',['as' => 'editUser']);
 $routes->post('save-edit-user/(:num)', '\Admin\Controllers\Users::saveEditUser/$1',['as' => 'saveEditUser']);
 $routes->post('delete-user/(:num)', '\Admin\Controllers\Users::deleteUser/$1',['as' => 'deleteUser']);

 $routes->get('Admin/company', '\Admin\Controllers\CompanyController::index',['as' => 'viewCompany']);
 $routes->post('save-edit-company/(:num)', '\Admin\Controllers\CompanyController::saveEditCompany/$1',['as' => 'saveEditCompany']);
 $routes->post('delete-company/(:num)', '\Admin\Controllers\CompanyController::deleteCompany/$1',['as' => 'deleteCompany']);

 $routes->get('profile', '\Admin\Controllers\profileController::index',['as' => 'profile']);
 $routes->post('save-edit-profile/(:num)', '\Admin\Controllers\profileController::saveEditProfile/$1',['as' => 'saveEditProfile']);
 $routes->post('update-password', '\Admin\Controllers\profileController::updatePassword',['as' => 'updatePassword']);

 $routes->get('edit-company', '\Admin\Controllers\profileController::editCompany');
 $routes->post('save-edit-company-profile/(:num)', '\Admin\Controllers\profileController::saveEditCompProfile/$1',['as' => 'saveEditCompProfile']);
 $routes->post('save-main-admin-changes/(:num)', '\Admin\Controllers\profileController::saveMainAdminChanges/$1',['as' => 'saveMainAdminChanges']);



 

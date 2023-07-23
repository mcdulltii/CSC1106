<?php

namespace Config;

use App\Controllers\FormBuilder;
use App\Controllers\FormGeneratorController;
use App\Controllers\Home;
use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Controllers\RegistrationController;
use App\Controllers\BaseController;
use App\Controllers\FormComponent;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');
$routes->get('form/create', [FormBuilder::class, 'index']);
$routes->get('form/edit/(:any)', [FormBuilder::class, 'editForm']);
$routes->get('form/delete/(:any)', [FormBuilder::class, 'deleteForm']);
$routes->match(['get', 'post'], 'form/export/(:any)', [FormBuilder::class, 'exportForm']);
$routes->post('form/save', [FormBuilder::class, 'saveForm']);

$routes->post('form-components/(:segment)', [[FormComponent::class, 'index'], '$1']);

$routes->match(['get', 'post'], '/login', 'LoginController::index');
$routes->match(['get', 'post'], '/register', 'RegistrationController::index');
$routes->get('/logout', 'LoginController::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
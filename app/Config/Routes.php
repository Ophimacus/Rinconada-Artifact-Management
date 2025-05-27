<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

// Add explicit root route
$routes->get('/', 'Home::index');

// Web Routes for Models CRUD
$routes->group('models', function($routes) {
    $routes->get('/', 'ModelsController::index');
    $routes->get('show/(:num)', 'ModelsController::show/$1');
    $routes->get('create', 'ModelsController::create');
    $routes->post('store', 'ModelsController::store');
    $routes->get('edit/(:num)', 'ModelsController::edit/$1');
    $routes->post('update/(:num)', 'ModelsController::update/$1');
    $routes->post('delete/(:num)', 'ModelsController::delete/$1');
});

// Artists CRUD routes
$routes->group('artists', function($routes) {
    $routes->get('/', 'ArtistsController::index');
    $routes->get('show/(:num)', 'ArtistsController::show/$1');
    $routes->get('new', 'ArtistsController::new');
    $routes->post('create', 'ArtistsController::create');
    $routes->get('edit/(:num)', 'ArtistsController::edit/$1');
    $routes->post('update/(:num)', 'ArtistsController::update/$1');
    $routes->post('delete/(:num)', 'ArtistsController::delete/$1');
});

// Artifacts CRUD routes
$routes->group('artifacts', function($routes) {
    $routes->get('/', 'ArtifactsController::index');
    $routes->get('show/(:num)', 'ArtifactsController::show/$1');
    $routes->get('new', 'ArtifactsController::new');
    $routes->post('create', 'ArtifactsController::create');
    $routes->get('edit/(:num)', 'ArtifactsController::edit/$1');
    $routes->match(['post', 'put'], 'update/(:num)', 'ArtifactsController::update/$1');
    $routes->post('delete/(:num)', 'ArtifactsController::delete/$1');
});

// Categories CRUD routes
$routes->group('categories', function($routes) {
    $routes->get('/', 'CategoriesController::index');
    $routes->get('show/(:num)', 'CategoriesController::show/$1');
    $routes->get('create', 'CategoriesController::create');
    $routes->post('store', 'CategoriesController::store');
    $routes->get('edit/(:num)', 'CategoriesController::edit/$1');
    $routes->post('update/(:num)', 'CategoriesController::update/$1');
    $routes->post('delete/(:num)', 'CategoriesController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * API Routes
 * --------------------------------------------------------------------
 */

// Models API Routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Model routes
    $routes->get('models', 'ModelApiController::index');
    $routes->get('models/(:num)', 'ModelApiController::show/$1');
    $routes->post('models', 'ModelApiController::create');
    $routes->put('models/(:num)', 'ModelApiController::update/$1');
    $routes->delete('models/(:num)', 'ModelApiController::delete/$1');
    $routes->post('models/upload', 'ModelApiController::upload');
    $routes->get('models/(:num)/preview', 'ModelApiController::preview/$1');

    // Location routes
    $routes->get('locations', 'LocationApiController::index');
    $routes->get('locations/(:num)', 'LocationApiController::show/$1');
    $routes->post('locations', 'LocationApiController::create');
    $routes->put('locations/(:num)', 'LocationApiController::update/$1');
    $routes->delete('locations/(:num)', 'LocationApiController::delete/$1');
    $routes->get('locations/(:num)/models', 'LocationApiController::getModels/$1');

    // Artist routes
    $routes->get('artists', 'ArtistApiController::index');
    $routes->get('artists/(:num)', 'ArtistApiController::show/$1');
    $routes->post('artists', 'ArtistApiController::create');
    $routes->put('artists/(:num)', 'ArtistApiController::update/$1');
    $routes->delete('artists/(:num)', 'ArtistApiController::delete/$1');
    $routes->get('artists/(:num)/models', 'ArtistApiController::getModels/$1');
});

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

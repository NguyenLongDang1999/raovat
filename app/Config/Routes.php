<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Backend
$routes->group('administrator', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
	// Dashboard
	$routes->get('/', 'DashboardController::index', ['as' => 'admin.dashboard.index']);

	// Category
	$routes->group('category', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
		$routes->get('/', 'CategoryController::index', ['as' => 'admin.category.index']);
		$routes->get('getList', 'CategoryController::getList', ['as' => 'admin.category.getList']);
		$routes->get('create', 'CategoryController::create', ['as' => 'admin.category.create']);
	});
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

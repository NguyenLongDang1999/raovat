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

// Frontend
$routes->group('', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
	// Home
	$routes->get('/', 'HomeController::index', ['as' => 'user.home.index']);

	// Post
	$routes->get('dang-tin', 'PostController::index', ['as' => 'user.post.index', 'filter' => 'login']);
	$routes->post('postPost', 'PostController::postPost', ['as' => 'user.post.postPost', 'filter' => 'login']);
	$routes->post('showDistrict', 'PostController::showDistrict', ['as' => 'user.post.showDistrict', 'filter' => 'login']);

	// User
	$routes->get('cap-nhat-thong-tin', 'UserController::index', ['as' => 'user.user.index', 'filter' => 'login']);
	$routes->get('thong-tin-ca-nhan', 'UserController::myProfile', ['as' => 'user.user.myProfile', 'filter' => 'login']);
	$routes->get('social-login-google', 'UserController::socialLoginGoogle', ['as' => 'user.user.socialLoginGoogle']);

	// Category
	$routes->get('(:any)/s(:num)', 'CategoryController::category/$1/$2', ['as' => 'user.category.category']);
	$routes->get('danh-muc-dang-tin', 'CategoryController::index', ['as' => 'user.category.index']);
});

// Backend
$routes->group('administrator', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin'], function ($routes) {
	// Dashboard
	$routes->get('/', 'DashboardController::index', ['as' => 'admin.dashboard.index']);

	// Category
	$routes->group('category', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin'], function ($routes) {
		$routes->get('/', 'CategoryController::index', ['as' => 'admin.category.index']);
		$routes->get('recycle', 'CategoryController::recycle', ['as' => 'admin.category.recycle']);
		$routes->get('getList', 'CategoryController::getList', ['as' => 'admin.category.getList']);
		$routes->get('getListRecycle', 'CategoryController::getListRecycle', ['as' => 'admin.category.getListRecycle']);
		$routes->get('create', 'CategoryController::create', ['as' => 'admin.category.create']);
		$routes->post('store', 'CategoryController::store', ['as' => 'admin.category.store']);
		$routes->get('edit/(:num)', 'CategoryController::edit/$1', ['as' => 'admin.category.edit']);
		$routes->post('update/(:num)', 'CategoryController::update/$1', ['as' => 'admin.category.update']);
		$routes->post('multiDestroy', 'CategoryController::multiDestroy', ['as' => 'admin.category.multiDestroy']);
		$routes->post('multiPurgeDestroy', 'CategoryController::multiPurgeDestroy', ['as' => 'admin.category.multiPurgeDestroy']);
		$routes->post('multiRestore', 'CategoryController::multiRestore', ['as' => 'admin.category.multiRestore']);
		$routes->post('multiStatus', 'CategoryController::multiStatus', ['as' => 'admin.category.multiStatus']);
		$routes->post('checkExists', 'CategoryController::checkExists', ['as' => 'admin.category.checkExists']);
	});

	// Banner
	$routes->group('banner', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin'], function ($routes) {
		$routes->get('/', 'BannerController::index', ['as' => 'admin.banner.index']);
		$routes->get('recycle', 'BannerController::recycle', ['as' => 'admin.banner.recycle']);
		$routes->get('getList', 'BannerController::getList', ['as' => 'admin.banner.getList']);
		$routes->get('getListRecycle', 'BannerController::getListRecycle', ['as' => 'admin.banner.getListRecycle']);
		$routes->get('create', 'BannerController::create', ['as' => 'admin.banner.create']);
		$routes->post('store', 'BannerController::store', ['as' => 'admin.banner.store']);
		$routes->get('edit/(:num)', 'BannerController::edit/$1', ['as' => 'admin.banner.edit']);
		$routes->post('update/(:num)', 'BannerController::update/$1', ['as' => 'admin.banner.update']);
		$routes->post('multiDestroy', 'BannerController::multiDestroy', ['as' => 'admin.banner.multiDestroy']);
		$routes->post('multiPurgeDestroy', 'BannerController::multiPurgeDestroy', ['as' => 'admin.banner.multiPurgeDestroy']);
		$routes->post('multiRestore', 'BannerController::multiRestore', ['as' => 'admin.banner.multiRestore']);
		$routes->post('multiStatus', 'BannerController::multiStatus', ['as' => 'admin.banner.multiStatus']);
		$routes->post('checkExists', 'BannerController::checkExists', ['as' => 'admin.banner.checkExists']);
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
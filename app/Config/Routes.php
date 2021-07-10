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
	$routes->get('(:any)/(:any)/s(:num)', 'PostController::detail/$1/$2/$3', ['as' => 'user.post.detail']);

	// User
	$routes->get('cap-nhat-thong-tin', 'UserController::index', ['as' => 'user.user.index', 'filter' => 'login']);
	$routes->get('thong-tin-ca-nhan', 'UserController::myProfile', ['as' => 'user.user.myProfile', 'filter' => 'login']);

	// Category
	$routes->get('(:any)/s(:num)', 'CategoryController::category/$1/$2', ['as' => 'user.category.category']);
	$routes->get('danh-muc-dang-tin', 'CategoryController::index', ['as' => 'user.category.index']);
	$routes->get('tin-dang-moi-nhat', 'CategoryController::newPost', ['as' => 'user.category.new_post']);

	// Comment
	$routes->post('postComment', 'CommentController::postComment', ['as' => 'user.comment.postComment']);
	$routes->post('showComments', 'CommentController::showComments', ['as' => 'user.comment.showComments']);

	// Manager
	$routes->get('quan-ly-tin-dang', 'ManagerController::index', ['as' => 'user.user.manager', 'filter' => 'login']);
	$routes->get('quan-ly-tin-dang/s(:num)/edit', 'ManagerController::edit/$1', ['as' => 'user.manager.edit', 'filter' => 'login']);
	$routes->get('getPostList', 'ManagerController::getPostList', ['as' => 'user.manager.getPostList', 'filter' => 'login']);
	$routes->get('getPostListBlock', 'ManagerController::getPostListBlock', ['as' => 'user.manager.getPostListBlock', 'filter' => 'login']);
	$routes->get('getPostListReady', 'ManagerController::getPostListReady', ['as' => 'user.manager.getPostListReady', 'filter' => 'login']);
	$routes->get('getPostListExpire', 'ManagerController::getPostListExpire', ['as' => 'user.manager.getPostListExpire', 'filter' => 'login']);
	$routes->get('getPostListSave', 'ManagerController::getPostListSave', ['as' => 'user.manager.getPostListSave', 'filter' => 'login']);
	$routes->post('quan-ly-tin-dang/s(:num)/update', 'ManagerController::update/$1', ['as' => 'user.manager.update', 'filter' => 'login']);
	$routes->post('quan-ly-tin-dang/multiStatus', 'ManagerController::multiStatus', ['as' => 'user.post.multiStatus', 'filter' => 'login']);

	// Favoritess
	$routes->post('userFavorites', 'FavoritesController::index', ['as' => 'user.favorites.index']);
	$routes->post('showFavorites', 'FavoritesController::showFavorites', ['as' => 'user.favorites.showFavorites']);
	$routes->post('removeFavorites', 'FavoritesController::removeFavorites', ['as' => 'user.favorites.removeFavorites']);
});

// Backend
$routes->group('administrator', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin,super-admin'], function ($routes) {
	// Dashboard
	$routes->get('/', 'DashboardController::index', ['as' => 'admin.dashboard.index']);

	// Category
	$routes->group('category', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin,super-admin'], function ($routes) {
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
	$routes->group('banner', ['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin,super-admin'], function ($routes) {
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

	// Post
	$routes->group('post' ,['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin,super-admin'], function($routes)
	{
		$routes->get('/', 'PostController::index', ['as' => 'admin.post.index']);
		$routes->get('recycle', 'PostController::recycle', ['as' => 'admin.post.recycle']);
        $routes->get('getList', 'PostController::getList', ['as' => 'admin.post.getList']);
		$routes->get('getListRecycle', 'PostController::getListRecycle', ['as' => 'admin.post.getListRecycle']);
        $routes->get('edit/(:num)', 'PostController::edit/$1', ['as' => 'admin.post.edit']);
        $routes->post('update/(:num)', 'PostController::update/$1', ['as' => 'admin.post.update']);
        $routes->post('multiDestroy', 'PostController::multiDestroy', ['as' => 'admin.post.multiDestroy']);
		$routes->post('multiPurgeDestroy', 'PostController::multiPurgeDestroy', ['as' => 'admin.post.multiPurgeDestroy']);
		$routes->post('multiRestore', 'PostController::multiRestore', ['as' => 'admin.post.multiRestore']);
        $routes->post('multiStatus', 'PostController::multiStatus', ['as' => 'admin.post.multiStatus']);
		$routes->post('multiFeatured', 'PostController::multiFeatured', ['as' => 'admin.post.multiFeatured']);
		$routes->get('s(:num)/detail', 'PostController::detail/$1', ['as' => 'admin.post.detail']);
		$routes->get('s(:num)/showEdit', 'PostController::showEdit/$1', ['as' => 'admin.post.showEdit']);
	});

	// Group
	$routes->group('group' ,['namespace' => 'App\Controllers\Backend', 'filter' => 'role:admin,super-admin'], function($routes)
	{
		$routes->get('/', 'GroupController::index', ['as' => 'admin.group.index']);
		$routes->get('getList', 'GroupController::getList', ['as' => 'admin.group.getList']);
		$routes->get('create', 'GroupController::create', ['as' => 'admin.group.create']);
		$routes->post('store', 'GroupController::store', ['as' => 'admin.group.store']);
		$routes->get('edit/(:num)', 'GroupController::edit/$1', ['as' => 'admin.group.edit']);
		$routes->post('update/(:num)', 'GroupController::update/$1', ['as' => 'admin.group.update']);
		$routes->post('multiPurgeDestroy', 'GroupController::multiPurgeDestroy', ['as' => 'admin.group.multiPurgeDestroy']);
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
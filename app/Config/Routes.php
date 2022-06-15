<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('User');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
 
 $routes->group('patient', function($routes){
     $routes->get('/', 'PatientController::index', ['filter' => 'auth']);
     $routes->match(['post', 'get'],'search', 'PatientController::index', ['filter' => 'auth']);
     $routes->match(['post', 'get'], 'register', 'PatientController::register', ['filter' => 'auth']);
     $routes->match(['post', 'get'], 'send_to_consultation/(:num)', 'PatientController::send_to_consultation/$1', ['filter' => 'auth']);
 });
 
 $routes->group('consultation', function($routes){
     $routes->get('list', 'ConsultationController::list', ['filter' => 'auth']);
     $routes->get('fees', 'ConsultationController::fees', ['filter' => 'auth']);
     $routes->match(['post','get'],'add_fee', 'ConsultationController::add_fee', ['filter' => 'auth']);
     $routes->match(['post', 'get'], 'update_fee/(:num)', 'ConsultationController::update_fee/$1',  ['filter' => 'auth']);
     $routes->get('delete_fee/(:num)', 'ConsultationController::delete_fee/$1',  ['filter' => 'auth']);
 });

 $routes->group('store', function($routes){
     $routes->match(['post', 'get'], 'additem', 'StoreController::addItem',  ['filter' => 'auth']);
     $routes->match(['post', 'get'], 'updateitem/(:num)', 'StoreController::updateItem/$1',  ['filter' => 'auth']);
     $routes->get('items', 'StoreController::listItems',  ['filter' => 'auth']);
     $routes->get('outofstock', 'StoreController::OutOfStock',  ['filter' => 'auth']);
     $routes->get('itemsneartoend', 'StoreController::ItemsNearToEnd',  ['filter' => 'auth']);
     $routes->get('deleteitem/(:num)', 'StoreController::deleteItem/$1',  ['filter' => 'auth']);
 });

 $routes->group('sales', function($routes){
     $routes->match(['post', 'get'], 'items', 'StoreController::salesItems', ['filter' => 'auth']);
     $routes->match(['post', 'get'],'addsale', 'StoreController::addSale',  ['filter' => 'auth']);
     $routes->match(['post', 'get'],'removesale', 'StoreController::removesale',  ['filter' => 'auth']);
     $routes->match(['post', 'get'],'ajax_add_sale', 'StoreController::ajax_add_sale',  ['filter' => 'auth']);
     $routes->get('searchsale', 'StoreController::searchSale',  ['filter' => 'auth']);
 });

 $routes->group('expense', function($routes){
     $routes->match(['post', 'get'], 'list', 'ExpenseController::list',  ['filter' => 'auth']);
     $routes->match(['post', 'get'],'add', 'ExpenseController::add',  ['filter' => 'auth']);
     $routes->match(['post', 'get'],'edit/(:num)', 'ExpenseController::edit/$1',  ['filter' => 'auth']);
     $routes->get('delete/(:num)', 'ExpenseController::delete_expense/$1',  ['filter' => 'auth']);
     $routes->get('searchsale', 'ExpenseController::searchSale',  ['filter' => 'auth']);
 });

 $routes->group('report', function($routes){
     $routes->get('/', 'ReportController::index', ['filter' => 'auth']);
     $routes->match(['post', 'get'],'generate', 'ReportController::generate_report', ['filter' => 'auth']);
     $routes->match(['post', 'get'],'risit', 'ReportController::sales_risit', ['filter' => 'auth']);
 });
 
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'User::index', ['filter' => 'noauth']);
$routes->group('user', function($routes){
    $routes->match(['post','get'], 'User::login', ['filter' => 'noauth']);
    $routes->match(['post','get'],'registration', 'User::registration', ['filter' => 'auth']);
    $routes->match(['post','get'],'edit/(:num)', 'User::updateUSerInfo/$1',  ['filter' => 'auth']);
    $routes->match(['post', 'get'], 'hidden-registration', 'User::registerSuperuser');
    $routes->get('delete/(:num)', 'User::delete/$1', ['filter' => 'auth']);
    $routes->get('logout', 'User::logout');
    $routes->get('list', 'User::list',  ['filter' => 'auth']);
    $routes->get('info/(:num)', 'User::userInfo/$1',  ['filter' => 'auth']);
    $routes->match(['post', 'get'], 'permission/(:num)', 'User::userPermission/$1',  ['filter' => 'auth']);
});

// $routes->group('account', function($routes){
//     $routes->match(['post', 'get'], 'login', 'User::index', ['filter' => 'noauth']);
//     $routes->match(['post', 'get'], 'registration', 'User::registration', ['filter' => 'noauth']);
//     $routes->match(['post', 'get'],'info', 'User::accountInfo');
//     $routes->get('delete/(:num)', 'User::delectAccount/$1');
//     $routes->get('user/(:num)', 'User::userAccount/$1', ['filter' => 'auth']);
//     $routes->match(['get','post'],'confirm/(:num)', 'User::confirmUserInfo/$1', ['filter' => 'auth']);
//     $routes->match(['get','post'],'block/(:num)', 'User::BlockUser/$1', ['filter' => 'auth']);
//     $routes->get('blocked', 'User::AccountBlocked');
// });

// $routes->group('dashboard', function($routes){
//     $routes->get('overview', 'DashboardController::index', ['filter' => 'auth'] );
//     $routes->get('users', 'User::getUsers', ['filter' => 'auth']);
// });


// $routes->match(['post', 'get'], 'superuser', 'User::registerSuperuser', ['filter' => 'noauth']);


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

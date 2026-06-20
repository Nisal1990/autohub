<?php
/**
 * AutoHub LK — Front Controller
 *
 * All requests routed here via /public/.htaccess
 */

// ─── Bootstrap ───────────────────────────────────────────────────────────────
define('ROOT', dirname(__DIR__));

require_once ROOT . '/config/config.php';
require_once ROOT . '/config/database.php';
require_once ROOT . '/app/core/Model.php';
require_once ROOT . '/app/core/Controller.php';
require_once ROOT . '/app/core/Router.php';
require_once ROOT . '/includes/auth.php';
require_once ROOT . '/includes/helpers.php';

// ─── Routes ──────────────────────────────────────────────────────────────────
$router = new Router();

// Public
$router->get('/',                      'HomeController@index');
$router->get('/about',                 'AboutController@index');
$router->get('/contact',               'ContactController@show');
$router->post('/contact',              'ContactController@submit');
$router->get('/promotions',            'PromotionController@index');

// Vehicles
$router->get('/vehicles',              'VehicleController@index');
$router->get('/vehicles/{id}',         'VehicleController@show');
$router->post('/vehicles/{id}/inquiry','VehicleController@inquiry');

// Parts
$router->get('/parts',                 'PartController@index');
$router->get('/parts/{id}',            'PartController@show');
$router->post('/parts/{id}/inquiry',   'PartController@inquiry');

// Services
$router->get('/services',              'ServiceController@index');
$router->get('/services/{id}',         'ServiceController@show');
$router->post('/services/{id}/inquiry','ServiceController@inquiry');

// Auth
$router->get('/login',                 'AuthController@showLogin');
$router->post('/login',                'AuthController@login');
$router->get('/register',              'AuthController@showRegister');
$router->post('/register',             'AuthController@register');
$router->get('/logout',                'AuthController@logout');
$router->get('/forgot-password',       'AuthController@showForgotPassword');
$router->post('/forgot-password',      'AuthController@forgotPassword');

// AJAX helpers
$router->get('/ajax/models',           'VehicleController@ajaxModels');
$router->get('/ajax/cities',           'ContactController@ajaxCities');

// ─── Dashboard (requires login) ───────────────────────────────────────────────
$router->get('/dashboard',                         'DashboardController@index');
$router->get('/dashboard/profile',                 'DashboardController@profile');
$router->post('/dashboard/profile',                'DashboardController@updateProfile');

// Dashboard — Vehicles
$router->get('/dashboard/vehicles',                'DashboardController@myVehicles');
$router->get('/dashboard/vehicles/create',         'DashboardController@createVehicle');
$router->post('/dashboard/vehicles/create',        'DashboardController@storeVehicle');
$router->get('/dashboard/vehicles/{id}/edit',      'DashboardController@editVehicle');
$router->post('/dashboard/vehicles/{id}/edit',     'DashboardController@updateVehicle');
$router->post('/dashboard/vehicles/{id}/delete',   'DashboardController@deleteVehicle');
$router->post('/dashboard/vehicles/{id}/sold',     'DashboardController@markVehicleSold');

// Dashboard — Parts
$router->get('/dashboard/parts',                   'DashboardController@myParts');
$router->get('/dashboard/parts/create',            'DashboardController@createPart');
$router->post('/dashboard/parts/create',           'DashboardController@storePart');
$router->get('/dashboard/parts/{id}/edit',         'DashboardController@editPart');
$router->post('/dashboard/parts/{id}/edit',        'DashboardController@updatePart');
$router->post('/dashboard/parts/{id}/delete',      'DashboardController@deletePart');

// Dashboard — Services
$router->get('/dashboard/services',                'DashboardController@myServices');
$router->get('/dashboard/services/provider/edit',  'DashboardController@editProvider');
$router->post('/dashboard/services/provider/edit', 'DashboardController@updateProvider');
$router->get('/dashboard/services/create',         'DashboardController@createService');
$router->post('/dashboard/services/create',        'DashboardController@storeService');
$router->get('/dashboard/services/{id}/edit',      'DashboardController@editService');
$router->post('/dashboard/services/{id}/edit',     'DashboardController@updateService');
$router->post('/dashboard/services/{id}/delete',   'DashboardController@deleteService');
$router->post('/dashboard/services/{id}/addon',    'DashboardController@addAddon');
$router->post('/dashboard/addons/{id}/delete',     'DashboardController@deleteAddon');

// Dashboard — Inquiries
$router->get('/dashboard/inquiries',               'DashboardController@inquiries');

// ─── Admin Panel ─────────────────────────────────────────────────────────────
$router->get('/admin/login',                        'AdminController@showLogin');
$router->post('/admin/login',                       'AdminController@login');
$router->get('/admin/logout',                       'AdminController@logout');

$router->get('/admin',                              'AdminController@dashboard');
$router->get('/admin/dashboard',                    'AdminController@dashboard');

// Admin — Users
$router->get('/admin/users',                        'AdminController@users');
$router->post('/admin/users/{id}/suspend',          'AdminController@suspendUser');
$router->post('/admin/users/{id}/activate',         'AdminController@activateUser');
$router->post('/admin/users/{id}/delete',           'AdminController@deleteUser');

// Admin — Vehicles
$router->get('/admin/vehicles',                     'AdminController@vehicles');
$router->post('/admin/vehicles/{id}/approve',       'AdminController@approveVehicle');
$router->post('/admin/vehicles/{id}/reject',        'AdminController@rejectVehicle');
$router->post('/admin/vehicles/{id}/feature',       'AdminController@featureVehicle');
$router->post('/admin/vehicles/{id}/delete',        'AdminController@deleteVehicle');

// Admin — Parts
$router->get('/admin/parts',                        'AdminController@parts');
$router->post('/admin/parts/{id}/approve',          'AdminController@approvePart');
$router->post('/admin/parts/{id}/reject',           'AdminController@rejectPart');
$router->post('/admin/parts/{id}/feature',          'AdminController@featurePart');
$router->post('/admin/parts/{id}/delete',           'AdminController@deletePart');

// Admin — Services
$router->get('/admin/services',                     'AdminController@services');
$router->post('/admin/services/{id}/approve',       'AdminController@approveService');
$router->post('/admin/services/{id}/reject',        'AdminController@rejectService');
$router->post('/admin/services/{id}/delete',        'AdminController@deleteService');

// Admin — Lookup Data
$router->get('/admin/lookup',                       'AdminController@lookup');
$router->post('/admin/lookup/manufacturer',         'AdminController@saveManufacturer');
$router->post('/admin/lookup/manufacturer/{id}/delete', 'AdminController@deleteManufacturer');
$router->post('/admin/lookup/model',                'AdminController@saveModel');
$router->post('/admin/lookup/model/{id}/delete',    'AdminController@deleteModel');
$router->post('/admin/lookup/part-category',        'AdminController@savePartCategory');
$router->post('/admin/lookup/part-category/{id}/delete', 'AdminController@deletePartCategory');
$router->post('/admin/lookup/service-category',     'AdminController@saveServiceCategory');
$router->post('/admin/lookup/service-category/{id}/delete', 'AdminController@deleteServiceCategory');
$router->post('/admin/lookup/district',             'AdminController@saveDistrict');
$router->post('/admin/lookup/city',                 'AdminController@saveCity');
$router->post('/admin/lookup/city/{id}/delete',     'AdminController@deleteCity');

// Admin — Promotions
$router->get('/admin/promotions',                   'AdminController@promotions');
$router->post('/admin/promotions/add',              'AdminController@addPromotion');
$router->post('/admin/promotions/{id}/remove',      'AdminController@removePromotion');

// Admin — Inquiries
$router->get('/admin/inquiries',                    'AdminController@inquiries');
$router->get('/admin/inquiries/{id}',               'AdminController@viewInquiry');
$router->post('/admin/inquiries/{id}/delete',       'AdminController@deleteInquiry');

// Admin — Reports
$router->get('/admin/reports',                      'AdminController@reports');

// ─── Dispatch ────────────────────────────────────────────────────────────────
$url    = $_GET['url'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($url, $method);

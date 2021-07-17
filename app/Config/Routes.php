<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->post('auth/login', 'Auth::login');
$routes->group('api', ['namespace' => 'App\Controllers\API', 'filter' => 'auth'], function($routes) {
	$routes->get('clientes', 'Cliente::index');
	$routes->post('clientes/create', 'Cliente::create');
	$routes->get('clientes/edit/(:num)', 'Cliente::edit/$1');
	$routes->put('clientes/update/(:num)', 'Cliente::update/$1');
	$routes->delete('clientes/delete/(:num)', 'Cliente::delete/$1');

	$routes->get('cuentas', 'Cuenta::index');
	$routes->post('cuentas/create', 'Cuenta::create');
	$routes->get('cuentas/edit/(:num)', 'Cuenta::edit/$1');
	$routes->put('cuentas/update/(:num)', 'Cuenta::update/$1');
	$routes->delete('cuentas/delete/(:num)', 'Cuenta::delete/$1');

	$routes->get('tipos-transaccion', 'TipoTransaccion::index');
	$routes->post('tipos-transaccion/create', 'TipoTransaccion::create');
	$routes->get('tipos-transaccion/edit/(:num)', 'TipoTransaccion::edit/$1');
	$routes->put('tipos-transaccion/update/(:num)', 'TipoTransaccion::update/$1');
	$routes->delete('tipos-transaccion/delete/(:num)', 'TipoTransaccion::delete/$1');

	$routes->get('transacciones', 'Transaccion::index');
	$routes->post('transacciones/create', 'Transaccion::create');
	$routes->get('transacciones/cliente/(:num)', 'Transaccion::getTransaccionesPorCliente/$1');

	$routes->get('roles', 'Role::index');
	$routes->post('roles/create', 'Role::create');
	$routes->get('roles/edit/(:num)', 'Role::edit/$1');
	$routes->put('roles/update/(:num)', 'Role::update/$1');
	$routes->delete('roles/delete/(:num)', 'Role::delete/$1');

	$routes->get('usuarios', 'Usuario::index');
	$routes->post('usuarios/create', 'Usuario::create');
	$routes->get('usuarios/edit/(:num)', 'Usuario::edit/$1');
	$routes->put('usuarios/update/(:num)', 'Usuario::update/$1');
	$routes->delete('usuarios/delete/(:num)', 'Usuario::delete/$1');	
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

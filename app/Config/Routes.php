<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('sezona/(:num)', 'Main::sezona/$1');
$routes->get('novinky', 'Main::novinky');
$routes->get('article/(:num)-(:any)', 'Main::article/$1');
$routes->get('administrace', 'Main::administrace');
$routes->get('create', 'Main::create');
$routes->post('store', 'Main::store');
$routes->post('delete/(:num)', 'Main::delete/$1');
$routes->post('edit/(:num)', 'Main::edit/$1');
$routes->get('edit/(:num)', 'Main::edit/$1');
$routes->post('update/(:num)', 'Main::update/$1');

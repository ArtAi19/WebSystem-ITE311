<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Authentication Routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');

// Debug routes (remove in production)
$routes->get('/auth/refresh_session', 'Auth::refresh_session');
$routes->get('/auth/check_db', 'Auth::check_db');
$routes->get('/auth/fix_database', 'Auth::fix_database');
$routes->get('/auth/debug_roles', 'Auth::debug_roles');
$routes->get('/auth/fix_user_role/(:num)/(:alpha)', 'Auth::fix_user_role/$1/$2');

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MainController::index');
$routes->post('/saveSong', 'MainController::upload');
$routes->get('/searchSong', 'MainController::searchSong');
$routes->post('/createPlaylist', 'MainController::createPlaylist');
$routes->post('/addToPlaylist', 'MainController::addToPlaylist');
$routes->get('/playlist/(:any)', 'MainController::playlist/$1');


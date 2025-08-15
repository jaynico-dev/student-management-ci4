<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Students Routes
$routes->get('/students', 'StudentsController::index');
$routes->get('/students/create', 'StudentsController::createStudent');
$routes->get('/students/edit/(:num)', 'StudentsController::editStudent/$1');   
$routes->delete('/students/delete/(:num)', 'StudentsController::deleteStudent/$1');
$routes->get('/students/profile/(:segment)', 'StudentsController::serveImage/$1');
$routes->post('/students/store', 'StudentsController::storeStudent');
$routes->post('/students/update/(:num)', 'StudentsController::updateStudent/$1');
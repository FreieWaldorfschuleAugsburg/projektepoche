<?php

use App\Filters\AdminFilter;
use App\Filters\LoggedInFilter;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IndexController::index');

$routes->get('/login', 'AuthenticationController::login');
$routes->post('/login', 'AuthenticationController::handleCredentials');
$routes->get('/logout', 'AuthenticationController::logout');

$routes->get('/users', 'UserController::index', ['filter' => AdminFilter::class]);
$routes->get('/user/create', 'UserController::create', ['filter' => AdminFilter::class]);
$routes->post('/user/create', 'UserController::handleCreate', ['filter' => AdminFilter::class]);
$routes->get('/user/edit', 'UserController::edit', ['filter' => AdminFilter::class]);
$routes->post('/user/edit', 'UserController::handleEdit', ['filter' => AdminFilter::class]);
$routes->get('/user/print/credentials', 'UserController::printCredentials', ['filter' => AdminFilter::class]);
$routes->get('/user/print/projects', 'UserController::printProjects', ['filter' => AdminFilter::class]);
$routes->get('/users/print/all/credentials', 'UserController::printAllCredentials', ['filter' => AdminFilter::class]);
$routes->get('/users/credentials/download', 'UserController::downloadCredentials', ['filter' => AdminFilter::class]);
$routes->get('/user/delete', 'UserController::delete', ['filter' => AdminFilter::class]);
$routes->get('user/import', 'UserController::import', ['filter' => AdminFilter::class]);
$routes->post('user/import', 'UserController::handleImport', ['filter' => AdminFilter::class]);

$routes->get('users/api/all', 'ApiController::allUsers', ['filter' => AdminFilter::class]);
$routes->post('users/api/all/upload/pdf', 'ApiController::uploadAllCredentials', ['filter' => AdminFilter::class]);
$routes->post('users/api/upload/pdf', 'ApiController::uploadCredentials', ['filter' => AdminFilter::class]);
$routes->post('users/api/generateQr', 'ApiController::renderQr', ['filter' => AdminFilter::class]);

$routes->get('code', 'UserController::code');

$routes->get('/projects', 'ProjectController::index', ['filter' => AdminFilter::class]);
$routes->get('/project/create', 'ProjectController::create', ['filter' => AdminFilter::class]);
$routes->post('/project/create', 'ProjectController::handleCreate', ['filter' => AdminFilter::class]);
$routes->get('/project/redistribute', 'ProjectController::redistribute', ['filter' => AdminFilter::class]);
$routes->get('/project/move', 'ProjectController::handleMove', ['filter' => AdminFilter::class]);
$routes->get('/project/print/overview', 'ProjectController::printOverview', ['filter' => AdminFilter::class]);
$routes->get('/project/print/total', 'ProjectController::printTotal', ['filter' => AdminFilter::class]);
$routes->get('/project/print/info', 'ProjectController::printInfo', ['filter' => AdminFilter::class]);
$routes->get('/project/print/members', 'ProjectController::printMembers', ['filter' => AdminFilter::class]);
$routes->get('/project/edit', 'ProjectController::edit', ['filter' => AdminFilter::class]);
$routes->post('/project/edit', 'ProjectController::handleEdit', ['filter' => AdminFilter::class]);
$routes->get('/project/delete', 'ProjectController::delete', ['filter' => AdminFilter::class]);

$routes->get('/slots', 'SlotController::index', ['filter' => AdminFilter::class]);

$routes->post('/vote', 'VoteController::handleVote', ['filter' => LoggedInFilter::class]);

$routes->get('/voting', 'VoteController::index', ['filter' => AdminFilter::class]);
$routes->get('/voting/state', 'VoteController::handleStateChange', ['filter' => AdminFilter::class]);
$routes->get('/voting/reset', 'VoteController::handleReset', ['filter' => AdminFilter::class]);

$routes->post('/api/upload', 'ApiController::uploadCredentials');
<?php

// Cette ligne me permet juste de dire
// à PHPStorm que la variable $router existe
// et qu'elle est de type Mvc\Routings\Router
/** @var Router $router */

use App\Controllers\AccountController;
use Mvc\Routings\Router;

$router->get('/', AccountController::class . '@index');

$router->get('/login', AccountController::class . '@signin');
$router->post('/login', AccountController::class . '@login');

$router->get('/register', AccountController::class . '@signup');
$router->post('/register', AccountController::class . '@register');

$router->get('/logout', AccountController::class . '@logout');

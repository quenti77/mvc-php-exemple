<?php

// Cette ligne me permet juste de dire
// à PHPStorm que la variable $router existe
// et qu'elle est de type Mvc\Routings\Router
/** @var Router $router */

use App\Controllers\BlogController;
use Mvc\Routings\Router;

$router->get('/blog', BlogController::class . '@index');
$router->get('/blog/:id-:slug', BlogController::class . '@show')
    ->with('id', '[0-9]+');

<?php

/** @var string ROOT_PATH */
define('ROOT_PATH', realpath(__DIR__ . '/../'));

// Autoloader de composer car vraiment plus efficaces
require ROOT_PATH . '/vendor/autoload.php';

use Mvc\Application;
use Mvc\Http\ServerRequest;

$request = ServerRequest::generate();

$app = new Application(ROOT_PATH . '/app/configs/app.php');
$response = $app->run($request);

$response->render();

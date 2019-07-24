<?php

// Cette ligne me permet juste de dire
// à PHPStorm que la variable $dic existe
// et qu'elle est de type Mvc\Containers\Manager
/** @var Manager $dic */

use Mvc\Containers\Manager;
use Mvc\Databases\ConnectionInterface;
use Mvc\Databases\PDO\Connection;

$dic->set(ConnectionInterface::class, function (Manager $manager) {
    return new Connection('pgsql:host=localhost;dbname=test', 'postgres', 'root');
});

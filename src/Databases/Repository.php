<?php

namespace Mvc\Databases;

/**
 * Class Repository
 * @package Mvc\Databases
 */
class Repository
{
    /** @var ConnectionInterface $connection */
    protected $connection;

    /**
     * Repository constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
}

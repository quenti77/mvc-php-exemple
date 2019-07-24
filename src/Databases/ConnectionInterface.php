<?php

namespace Mvc\Databases;

/**
 * Interface ConnectionInterface
 * @package Mvc\Databases
 */
interface ConnectionInterface
{
    /**
     * @param string $statement
     * @param array $params
     * @return StatementInterface
     */
    public function request(string $statement, array $params = []): StatementInterface;
}

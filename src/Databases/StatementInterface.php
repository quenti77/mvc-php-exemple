<?php

namespace Mvc\Databases;

/**
 * Interface StatementInterface
 * @package Mvc\Databases
 */
interface StatementInterface
{
    /**
     * @param string $name
     * @param mixed $value
     * @param int $type
     * @return mixed
     */
    public function bind(string $name, $value, int $type);

    /**
     * @return bool
     */
    public function execute(): bool;

    /**
     * @return array|bool
     */
    public function fetch();
}

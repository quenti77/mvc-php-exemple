<?php

namespace Mvc\Databases;

/**
 * Trait HydrateTrait
 * @package Mvc\Databases
 */
trait HydrateTrait
{
    /**
     * @param array $data
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $name => $value) {
            $methodName = 'set' . str_replace('_', '', ucwords($name, '_'));

            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }
    }
}

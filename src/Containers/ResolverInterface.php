<?php

namespace Mvc\Containers;

/**
 * Interface ResolverInterface
 * @package Mvc\Containers
 */
interface ResolverInterface
{
    /**
     * @param Manager $manager
     * @param bool $forceMake
     * @return mixed
     */
    public function resolve(Manager $manager, bool $forceMake = false);
}

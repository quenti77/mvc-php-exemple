<?php

namespace Mvc\Containers\Resolvers;

use Mvc\Containers\Manager;
use Mvc\Containers\ResolverInterface;

/**
 * Class FactoryInstanceResolver
 * @package Mvc\Containers\Resolvers
 */
class FactoryInstanceResolver implements ResolverInterface
{
    /** @var callable $resolver */
    private $resolver;

    public function __construct(callable $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param Manager $manager
     * @param bool $forceMake
     * @return mixed
     */
    public function resolve(Manager $manager, bool $forceMake = false)
    {
        return call_user_func_array($this->resolver, [$manager]);
    }
}

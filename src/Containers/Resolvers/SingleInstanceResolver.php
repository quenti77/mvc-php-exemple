<?php

namespace Mvc\Containers\Resolvers;

use Mvc\Containers\Manager;
use Mvc\Containers\ResolverInterface;

/**
 * Class SingleInstanceResolver
 * @package Mvc\Containers\Resolvers
 */
class SingleInstanceResolver implements ResolverInterface
{
    /** @var mixed $instance */
    private $instance = null;

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
        if ($this->instance && !$forceMake) {
            return $this->instance;
        }

        $this->instance = call_user_func_array($this->resolver, [$manager]);
        return $this->instance;
    }
}

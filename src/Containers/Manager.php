<?php

namespace Mvc\Containers;

use Mvc\Containers\Resolvers\FactoryInstanceResolver;
use Mvc\Containers\Resolvers\SingleInstanceResolver;
use Mvc\Containers\Resolvers\WiringInstanceResolver;
use ReflectionException;

/**
 * Class Manager
 * @package Mvc\Containers
 */
class Manager
{
    /** @var ResolverInterface[] $resolvers */
    private $resolvers = [];

    /**
     * @param string $name
     * @param callable $resolver
     */
    public function set(string $name, callable $resolver)
    {
        $this->add($name, new SingleInstanceResolver($resolver));
    }

    /**
     * @param string $name
     * @param callable $resolver
     */
    public function factory(string $name, callable $resolver)
    {
        $this->add($name, new FactoryInstanceResolver($resolver));
    }

    /**
     * @param string $name
     * @param ResolverInterface $resolver
     */
    public function add(string $name, ResolverInterface $resolver)
    {
        $this->resolvers[$name] = $resolver;
    }

    /**
     * @param array $resolvers
     */
    public function addArray(array $resolvers)
    {
        foreach ($resolvers as $name => $resolver) {
            $this->add($name, $resolver);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public function get(string $name)
    {
        return $this->resolve($name, false);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws ReflectionException
     */
    public function make(string $name)
    {
        return $this->resolve($name, true);
    }

    /**
     * @param string $name
     * @param bool $forceMake
     * @return mixed
     * @throws ReflectionException
     */
    public function resolve(string $name, bool $forceMake)
    {
        $resolver = $this->resolvers[$name] ?? null;

        if ($resolver === null) {
            $resolver = new WiringInstanceResolver($name);
            $this->resolvers[$name] = $resolver;
        }

        return $resolver->resolve($this, $forceMake);
    }
}

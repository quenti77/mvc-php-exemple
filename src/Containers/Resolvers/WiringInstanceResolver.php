<?php

namespace Mvc\Containers\Resolvers;

use Mvc\Containers\Manager;
use Mvc\Containers\ResolverInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionFunctionAbstract;

/**
 * Class WiringInstanceResolver
 * @package Mvc\Containers\Resolvers
 */
class WiringInstanceResolver implements ResolverInterface
{
    const TYPES = [
        'string' => '',
        'int' => 0,
        'float' => 0.0,
        'bool' => false,
        'array' => []
    ];

    /** @var mixed $instance */
    private $instance = null;

    /** @var string $name */
    private $name;

    /**
     * WiringInstanceResolver constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Manager $manager
     * @param bool $forceMake
     * @return mixed
     * @throws ReflectionException
     */
    public function resolve(Manager $manager, bool $forceMake = false)
    {
        if ($this->instance && !$forceMake) {
            return $this->instance;
        }

        if (!class_exists($this->name)) {
            throw new ReflectionException("'{$this->name}' isn't a valid class");
        }
        $class = new ReflectionClass($this->name);

        if (!$class->isInstantiable()) {
            throw new ReflectionException("'{$this->name}' isn't an instantiable class");
        }

        $constructor = $class->getConstructor();
        if ($constructor) {
            $constructorParams = $this->generateMethodParameters($constructor, $manager);
            $instance = $class->newInstanceArgs($constructorParams);
        } else {
            $instance = $class->newInstance();
        }

        $this->instance = $instance;
        return $this->instance;
    }

    /**
     * @param ReflectionFunctionAbstract $function
     * @param Manager $manager
     * @return array
     * @throws ReflectionException
     */
    private function generateMethodParameters(ReflectionFunctionAbstract $function, Manager $manager): array
    {
        $params = [];
        $reflectionParams = $function->getParameters();

        foreach ($reflectionParams as $reflectionParam) {
            $type = $reflectionParam->getType();

            if ($reflectionParam->isDefaultValueAvailable()) {
                $params[] = $reflectionParam->getDefaultValue();
            } elseif ($type && $this->objectExist($type->getName())) {
                $params[] = $manager->get($type->getName());
            } elseif ($type === null || $type->allowsNull()) {
                $params[] = null;
            } elseif (array_key_exists($type->getName(), self::TYPES)) {
                $params[] = self::TYPES[$type->getName()];
            }
        }

        return $params;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function objectExist(string $name): bool
    {
        return class_exists($name) || interface_exists($name) || trait_exists($name);
    }
}

<?php

namespace Mvc\Routings;

use InvalidArgumentException;
use Mvc\Application;
use Mvc\Containers\Manager;
use Mvc\Containers\Resolvers\WiringInstanceResolver;
use Mvc\Http\Request;
use Mvc\Http\Response;
use Mvc\Http\TrimUriTrait;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Route
 * @package Mvc\Routings
 */
class Route
{
    use TrimUriTrait;

    /** @var string $method */
    private $method;

    /** @var string $uri */
    private $uri;

    /** @var string|callable $callback */
    private $callback;

    /** @var array $params */
    private $params = [];

    /** @var array $matches */
    private $matches = [];

    /**
     * Route constructor.
     * @param string $method
     * @param string $uri
     * @param $callback
     */
    public function __construct(string $method, string $uri, $callback)
    {
        $this->method = $method;
        $this->uri = $this->trimUri($uri);
        $this->callback = $callback;
    }

    /**
     * @param string $param
     * @param string $regex
     * @return Route
     */
    public function with(string $param, string $regex): Route
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request): bool
    {
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->uri);
        $regex = "#^{$path}$#i";

        $matches = [];
        if (!preg_match($regex, $request->getUri(), $matches)) {
            return false;
        }
        array_shift($matches);

        $matchNames = [];
        $regexName = "#:([\w]+)#i";

        preg_match_all($regexName, $this->uri, $matchNames);
        array_shift($matchNames);

        $this->matches = array_combine($matchNames[0], $matches);

        return true;
    }

    /**
     * @param Request $request
     * @param Application $application
     * @return Response
     * @throws ReflectionException
     */
    public function call(Request $request, Application $application): Response
    {
        $request = $request->withQueryParams($this->matches);

        $partsCallback = explode('@', $this->callback, 2);
        if (count($partsCallback) !== 2) {
            throw new InvalidArgumentException("{$this->callback} is not a valid callback. ControllerClass@method");
        }

        $class = $application->getManager()->resolve($partsCallback[0], false);
        $reflectionClass = new ReflectionClass($class);

        $reflectionMethod = $reflectionClass->getMethod($partsCallback[1]);
        $params = $this->generateMethodParams($reflectionMethod, $request, $application->getManager());

        return $reflectionMethod->invokeArgs($class, $params);
    }

    /**
     * @param array $match
     * @return string
     */
    private function paramMatch(array $match): string
    {
        $matchName = $match[1] ?? 0;
        $regex = $this->params[$matchName] ?? '[^/]+';

        return "({$regex})";
    }

    /**
     * @param ReflectionMethod $method
     * @param Request $request
     * @param Manager $manager
     * @return array
     * @throws ReflectionException
     */
    private function generateMethodParams(ReflectionMethod $method, Request $request, Manager $manager): array
    {
        $params = [];
        $reflectionParams = $method->getParameters();

        foreach ($reflectionParams as $reflectionParam) {
            $type = $reflectionParam->getType();

            if ($type->getName() === Request::class) {
                $params[] = $request;
            } elseif (array_key_exists($reflectionParam->getName(), $request->getQueryParams())) {
                $params[] = $request->getQueryParams()[$reflectionParam->getName()];
            } elseif ($reflectionParam->isDefaultValueAvailable()) {
                $params[] = $reflectionParam->getDefaultValue();
            } elseif ($type && class_exists($type->getName())) {
                $params[] = $manager->get($type->getName());
            } elseif ($type === null || $type->allowsNull()) {
                $params[] = null;
            } elseif (array_key_exists($type->getName(), WiringInstanceResolver::TYPES)) {
                $params[] = WiringInstanceResolver::TYPES[$type->getName()];
            }
        }

        return $params;
    }
}

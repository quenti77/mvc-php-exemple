<?php

namespace Mvc\Routings;

use Exception;
use InvalidArgumentException;
use Mvc\Application;
use Mvc\Http\Request;
use Mvc\Http\Response;

/**
 * Class Router
 * @package Mvc\Routings
 */
class Router
{
    /** @var array $routes */
    private $routes = [];

    /**
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function get(string $uri, $callback): Route
    {
        return $this->add('GET', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function post(string $uri, $callback): Route
    {
        return $this->add('POST', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function put(string $uri, $callback): Route
    {
        return $this->add('PUT', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function patch(string $uri, $callback): Route
    {
        return $this->add('PATCH', $uri, $callback);
    }

    /**
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function delete(string $uri, $callback): Route
    {
        return $this->add('DELETE', $uri, $callback);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param $callback
     * @return Route
     * @throws InvalidArgumentException
     */
    public function add(string $method, string $uri, $callback): Route
    {
        $method = strtoupper($method);
        if (!in_array($method, Request::AUTHORIZED_METHOD)) {
            throw new InvalidArgumentException("'{$method}' is not a valid method");
        }

        $route = new Route($method, $uri, $callback);

        $this->routes[$method][] = $route;

        return $route;
    }

    /**
     * @param Request $request
     * @param Application $application
     * @return Response
     * @throws Exception
     */
    public function run(Request $request, Application $application): Response
    {
        $routes = $this->routes[$request->getMethod()] ?? [];

        /** @var Route $route */
        foreach ($routes as $route) {
            if ($route->match($request)) {
                return $route->call($request, $application);
            }
        }

        throw new Exception("Request not found for [{$request->getMethod()}] {$request->getUri()}");
    }
}

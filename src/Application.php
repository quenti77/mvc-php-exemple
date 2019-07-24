<?php

namespace Mvc;

use Exception;
use InvalidArgumentException;
use Mvc\Containers\Manager;
use Mvc\Http\Request;
use Mvc\Http\Response;
use Mvc\Routings\Router;

/**
 * Class Application
 * @package Mvc
 */
class Application
{
    /** @var string $name */
    private $name;

    /** @var string $env */
    private $env;

    /** @var string $dicFile */
    private $dicFile;

    /** @var array $routes */
    private $routeFiles;

    /** @var Manager $dic */
    private $dic;

    /** @var Router $router */
    private $router;

    /**
     * Application constructor.
     * @param string $mainConfig
     */
    public function __construct(string $mainConfig)
    {
        $this->loadConfiguration($mainConfig);
        $this->initContainer();
        $this->initRouter();
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        return $this->dic;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function run(Request $request): Response
    {
        return $this->router->run($request, $this);
    }

    /**
     * @param string $config
     * @throws InvalidArgumentException
     */
    private function loadConfiguration(string $config)
    {
        /** @noinspection PhpIncludeInspection */
        $configurations = require $config;

        $this->name = $configurations['name'] ?? 'Basic app name';
        $this->env = $configurations['env'] ?? 'dev';

        $dicFile = $configurations['dic'] ?? '';
        if (!file_exists($dicFile)) {
            throw new InvalidArgumentException("The dic file '{$dicFile}' doesn't exist or not readable");
        }
        $this->dicFile = $dicFile;

        $routeFiles = $configurations['routes'] ?? [];
        if (!is_array($routeFiles)) {
            $routeFiles = [$routeFiles];
        }

        foreach ($routeFiles as $routeFile) {
            if (!file_exists($routeFile)) {
                throw new InvalidArgumentException("The route file '{$routeFile}' doesn't exist or not readable");
            }
        }
        $this->routeFiles = $routeFiles;
    }

    private function initContainer()
    {
        $dic = new Manager();

        /** @noinspection PhpIncludeInspection */
        require $this->dicFile;

        $this->dic = $dic;
    }

    private function initRouter()
    {
        $router = new Router();

        foreach ($this->routeFiles as $routeFile) {
            /** @noinspection PhpIncludeInspection */
            require $routeFile;
        }

        $this->router = $router;
    }
}

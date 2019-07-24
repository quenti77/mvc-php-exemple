<?php

namespace Mvc\Http;

use InvalidArgumentException;

/**
 * Class Request
 * @package Mvc\Http
 */
class Request
{
    use TrimUriTrait;

    /** @var string[] AUTHORIZED_METHOD */
    const AUTHORIZED_METHOD = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

    /** @var string $method */
    private $method;

    /** @var string $uri */
    private $uri;

    /** @var array $headers */
    private $headers;

    /** @var array $queryParams */
    private $queryParams;

    /**
     * Request constructor.
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param array $queryParams
     */
    public function __construct(
        string $method,
        string $uri,
        array $headers = [],
        array $queryParams = [])
    {
        $method = strtoupper($method);
        $this->assertMethod($method);

        $this->method = $method;
        $this->uri = $this->trimUri($uri);
        $this->headers = $headers;
        $this->queryParams = $queryParams;
    }

    /**
     * @param string $method
     * @return Request
     * @throws InvalidArgumentException
     */
    public function withMethod(string $method): Request
    {
        $method = strtoupper($method);
        $this->assertMethod($method);

        $clone = clone $this;
        $clone->method = $method;

        return $clone;
    }

    /**
     * @param string $name
     * @param string $header
     * @return Request
     */
    public function withHeader(string $name, string $header): Request
    {
        $clone = clone $this;
        $clone->headers[$name] = $header;

        return $clone;
    }

    /**
     * @param array $queryParams
     * @return Request
     */
    public function withQueryParams(array $queryParams): Request
    {
        $clone = clone $this;
        $clone->queryParams = array_merge($clone->queryParams, $queryParams);

        return $clone;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param string $method
     * @throws InvalidArgumentException
     */
    private function assertMethod(string $method)
    {
        if (!in_array($method, self::AUTHORIZED_METHOD)) {
            throw new InvalidArgumentException("Method '{$method}' is not a valid method name");
        }
    }
}

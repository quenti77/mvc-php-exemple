<?php

namespace Mvc\Http;

use InvalidArgumentException;

/**
 * Class Response
 * @package Mvc\Http
 */
class Response
{
    /** @var string $body */
    private $body;

    /** @var array $headers */
    private $headers;

    /**
     * @param string $body
     * @return Response
     */
    public function withBody(string $body): Response
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * @param string $name
     * @param string $header
     * @return Response
     */
    public function withHeader(string $name, string $header): Response
    {
        $clone = clone $this;
        $clone->headers[$name] = $header;

        return $clone;
    }

    /**
     * @return void
     */
    public function render(): void
    {
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->body;
    }
}

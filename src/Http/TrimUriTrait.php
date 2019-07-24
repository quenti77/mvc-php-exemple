<?php

namespace Mvc\Http;

/**
 * Trait TrimUriTrait
 * @package Mvc\Http
 */
trait TrimUriTrait
{
    /**
     * @param string $uri
     * @return string
     */
    public function trimUri(string $uri): string
    {
        $uri = trim($uri, '/');
        return empty($uri) ? '/' : $uri;
    }
}

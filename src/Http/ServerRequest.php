<?php

namespace Mvc\Http;

use InvalidArgumentException;

/**
 * Class ServerRequest
 * @package Mvc\Http
 */
class ServerRequest extends Request
{
    /**
     * @return ServerRequest
     * @throws InvalidArgumentException
     */
    public static function generate()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $fullUri = parse_url($_SERVER['REQUEST_URI'] ?? '');
        $uri = $fullUri['path'] ?? '/';

        $headers = [];
        self::addIfExist($headers, 'HTTP_ACCEPT');
        self::addIfExist($headers, 'HTTP_ACCEPT_LANGUAGE');
        self::addIfExist($headers, 'HTTP_USER_AGENT');

        $queryParams = [];
        parse_str($fullUri['query'] ?? '', $queryParams);

        return new ServerRequest($method, $uri, $headers, $queryParams);
    }

    /**
     * @param array $headers
     * @param string $search
     * @return array
     */
    private static function addIfExist(array &$headers, string $search): array
    {
        $header = $_SERVER[$search] ?? null;

        if ($header !== null) {
            $headers[$search] = $header;
        }

        return $headers;
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\Client;

interface InMemoryHttpClientInterface extends HttpClientInterface
{
    public function setResponse(InMemoryHttpClientResponse $response, string $method, string $url, array $options = []) : void;
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\Client;

use Symfony\Component\HttpClient\TraceableHttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class HttpClient implements HttpClientInterface
{
    protected TraceableHttpClient $client;

    public function __construct(TraceableHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(string $method, string $url, array $options = []) : ResponseInterface
    {
        return $this->client->request($method, $url, $options);
    }

    public function stream($responses, float $timeout = null) : ResponseStreamInterface
    {
        return $this->client->stream($responses, $timeout);
    }
}

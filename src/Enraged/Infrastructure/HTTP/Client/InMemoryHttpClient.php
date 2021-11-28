<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\Client;

use Enraged\Infrastructure\Exception\InfrastructureHttpBadResponseException;
use Enraged\Infrastructure\Exception\InfrastructureInvalidArgumentException;
use Enraged\Infrastructure\Exception\InfrastructureNotImplementedException;
use stdClass;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class InMemoryHttpClient implements HttpClientInterface, InMemoryHttpClientInterface
{
    /**
     * @var InMemoryHttpClientResponse[]
     */
    private array $cachedRequests = [];

    public function __call(string $name, array $arguments)
    {
        throw new InfrastructureNotImplementedException();
    }

    /**
     * @throws InfrastructureHttpBadResponseException
     * @throws InfrastructureInvalidArgumentException
     */
    public function request(string $method, string $url, array $options = []) : ResponseInterface
    {
        if (isset($this->cachedRequests[$key = $this->generateKey($method, $url, $options)])) {
            return $this->cachedRequests[$key];
        }
        throw new InfrastructureHttpBadResponseException();
    }

    /**
     * @throws InfrastructureNotImplementedException
     */
    public function stream($responses, float $timeout = null) : ResponseStreamInterface
    {
        throw new InfrastructureNotImplementedException();
    }

    /**
     * @throws InfrastructureInvalidArgumentException
     */
    public function setResponse(InMemoryHttpClientResponse $response, string $method, string $url, array $options = []) : void
    {
        $this->cachedRequests[$this->generateKey($method, $url, $options)] = $response;
    }

    /**
     * @throws InfrastructureInvalidArgumentException
     */
    private function generateKey(string $method, string $url, array $options = []) : string
    {
        $key = new stdClass();
        $key->method = $method;
        $key->url = $url;
        $key->options = $options;

        return md5(($json = json_encode($key)) ? $json : throw new InfrastructureInvalidArgumentException());
    }
}

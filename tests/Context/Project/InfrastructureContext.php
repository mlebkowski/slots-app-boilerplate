<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project;

use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\Client\InMemoryHttpClient;
use Psr\Container\ContainerInterface;
use RuntimeException;

class InfrastructureContext
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function httpClient() : InMemoryHttpClient
    {
        if (!(($http_client = $this->container->get(HttpClientInterface::class)) instanceof InMemoryHttpClient)) {
            throw new RuntimeException('One does not use live http client when testing.');
        }

        return $http_client;
    }
}

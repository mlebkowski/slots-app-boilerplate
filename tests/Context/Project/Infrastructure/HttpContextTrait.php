<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project\Infrastructure;

use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\Client\InMemoryHttpClient;
use RuntimeException;

trait HttpContextTrait
{
    public function httpClient() : InMemoryHttpClient
    {
        if (!(($http_client = $this->getContainer()->get(HttpClientInterface::class)) instanceof InMemoryHttpClient)) {
            throw new RuntimeException('One does not use live http client when testing.');
        }

        return $http_client;
    }
}

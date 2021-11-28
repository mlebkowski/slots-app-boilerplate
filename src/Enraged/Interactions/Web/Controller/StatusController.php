<?php

declare(strict_types=1);

namespace Enraged\Interactions\Web\Controller;

use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController
{
    protected HttpClientInterface $http_client;

    public function __construct(HttpClientInterface $http_client)
    {
        $this->http_client = $http_client;
    }

    #[Route('/', name: 'status_index')]
    public function indexHtml() : Response
    {
        return new Response('OK');
    }
}

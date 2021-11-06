<?php

declare(strict_types=1);

namespace App\Service\SlotFetching;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DoctorFetchingClient
{
    private HttpClientInterface $slotsApiClient;

    public function __construct(HttpClientInterface $slotsApiClient)
    {
        $this->slotsApiClient = $slotsApiClient;
    }

    public function getDoctorIds(): array
    {
        $response = $this->slotsApiClient->request(
            Request::METHOD_GET,
            'doctors'
        );

        $doctors = json_decode($response->getContent(), true);

        return array_column($doctors, 'id');
    }
}

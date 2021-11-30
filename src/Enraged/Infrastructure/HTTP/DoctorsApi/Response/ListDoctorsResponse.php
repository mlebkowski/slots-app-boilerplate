<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Response;

use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorModel;
use Enraged\Infrastructure\Exception\InfrastructureHttpBadRequestException;
use Enraged\Infrastructure\Exception\InfrastructureHttpException;
use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsDoctorsApiRequest;
use Iterator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ListDoctorsResponse
{
    use MakeRequestTrait;

    protected ListDoctorsDoctorsApiRequest $request;
    protected HttpClientInterface $http_client;

    public function __construct(ListDoctorsDoctorsApiRequest $request, HttpClientInterface $http_client)
    {
        $this->request = $request;
        $this->http_client = $http_client;
    }

    /**
     * @return Iterator<int, ExternalDoctorModel>
     *
     * @throws InfrastructureHttpException
     */
    public function iterator() : Iterator
    {
        foreach ($this->responseToArrayOfDoctors($this->makeRequest($this->request)) as $doctor) {
            yield ($id = intval($doctor['id'])) => new ExternalDoctorModel(
                $id,
                $doctor['name']
            );
        }
    }

    /**
     * @return array{name: string, id: int}[]
     *
     * @throws InfrastructureHttpException
     */
    private function responseToArrayOfDoctors(ResponseInterface $response) : array
    {
        try {
            return $response->toArray(true);
        } catch (ClientExceptionInterface $exception) {
            throw new InfrastructureHttpBadRequestException($exception->getMessage(), intval($exception->getCode()), $exception);
        } catch (DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $exception) {
            throw new InfrastructureHttpException($exception->getMessage(), intval($exception->getCode()), $exception);
        }
    }
}

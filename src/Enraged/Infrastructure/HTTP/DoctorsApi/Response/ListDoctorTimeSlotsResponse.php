<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Response;

use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotModel;
use Enraged\Infrastructure\Exception\InfrastructureHttpBadRequestException;
use Enraged\Infrastructure\Exception\InfrastructureHttpBadResponseException;
use Enraged\Infrastructure\Exception\InfrastructureHttpException;
use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsTimeSlotsRequest;
use Iterator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ListDoctorTimeSlotsResponse
{
    use MakeRequestTrait;

    protected ListDoctorsTimeSlotsRequest $request;
    protected HttpClientInterface $http_client;

    public function __construct(ListDoctorsTimeSlotsRequest $request, HttpClientInterface $http_client)
    {
        $this->request = $request;
        $this->http_client = $http_client;
    }

    /**
     * @return Iterator<int, ExternalDoctorTimeSlotModel>
     *
     * @throws InfrastructureHttpException
     */
    public function iterator() : Iterator
    {
        foreach ($this->responseToArrayOfDoctorTimeSlots($this->makeRequest($this->request)) as $slot) {
            yield new ExternalDoctorTimeSlotModel(
                $this->request->getDoctorId(),
                ($start = DateTimeImmutable::createFromFormat(DateTimeInterface::ISO8601, $slot['start'])) instanceof DateTimeInterface
                    ? $start
                    : throw new InfrastructureHttpBadResponseException('Invalid date format in api response. Expected ISO8601.'),
                ($end = DateTimeImmutable::createFromFormat(DateTimeInterface::ISO8601, $slot['end'])) instanceof DateTimeInterface
                    ? $end
                    : throw new InfrastructureHttpBadResponseException('Invalid date format in api response. Expected ISO8601.')
            );
        }
    }

    /**
     * @return array{start: string, end: string}[]
     *
     * @throws InfrastructureHttpException
     */
    private function responseToArrayOfDoctorTimeSlots(ResponseInterface $response) : array
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

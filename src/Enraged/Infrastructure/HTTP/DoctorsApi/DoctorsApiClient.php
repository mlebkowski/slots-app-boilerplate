<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi;

use Enraged\Infrastructure\Assertion\InfrastructureAssertion;
use Enraged\Infrastructure\Exception\InfrastructureHttpException;
use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorTimeSlotsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorTimeSlotModel;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsDoctorsApiRequest;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsTimeSlotsRequest;
use Enraged\Infrastructure\HTTP\DoctorsApi\Response\ListDoctorsResponse;
use Enraged\Infrastructure\HTTP\DoctorsApi\Response\ListDoctorTimeSlotsResponse;
use Iterator;

class DoctorsApiClient implements DoctorsApiInterface
{
    protected HttpClientInterface $http_client;
    protected string $username;
    protected string $password;
    protected string $api_host;

    public function __construct(HttpClientInterface $http_client, string $api_host, string $username, string $password)
    {
        InfrastructureAssertion::notEmpty($username, 'Doctors API host cannot be empty!');
        InfrastructureAssertion::notEmpty($username, 'Doctors API username cannot be empty!');
        InfrastructureAssertion::notEmpty($password, 'Doctors API password cannot be empty!');
        $this->http_client = $http_client;
        $this->api_host = $api_host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return Iterator<int, DoctorModel>
     *
     * @throws InfrastructureHttpException
     */
    public function listDoctors(ListDoctorsApiRequestFilter $filter) : Iterator
    {
        yield from (
        new ListDoctorsResponse(
            new ListDoctorsDoctorsApiRequest(
                $filter,
                $this->api_host,
                $this->username,
                $this->password
            ),
            $this->http_client
        )
        )->iterator();
    }

    /**
     * @return Iterator<int, DoctorTimeSlotModel>
     *
     * @throws InfrastructureHttpException
     */
    public function listDoctorTimeSlots(ListDoctorTimeSlotsApiRequestFilter $filter, int $doctorExternalId) : Iterator
    {
        yield from (
        new ListDoctorTimeSlotsResponse(
            new ListDoctorsTimeSlotsRequest(
                $filter,
                $doctorExternalId,
                $this->api_host,
                $this->username,
                $this->password
            ),
            $this->http_client
        )
        )->iterator();
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi;

use Enraged\Application\Query\Doctor\ExternalDoctors\ExternalDoctorsQueryInterface;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorsQuery;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorTimeSlotsQuery;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorsCollection;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotsCollection;
use Enraged\Infrastructure\Assertion\InfrastructureAssertion;
use Enraged\Infrastructure\Exception\InfrastructureHttpException;
use Enraged\Infrastructure\HTTP\Client\HttpClientInterface;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsDoctorsApiRequest;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\ListDoctorsTimeSlotsRequest;
use Enraged\Infrastructure\HTTP\DoctorsApi\Response\ListDoctorsResponse;
use Enraged\Infrastructure\HTTP\DoctorsApi\Response\ListDoctorTimeSlotsResponse;

class ExternalDoctorsApiClient implements ExternalDoctorsQueryInterface
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
     * @throws InfrastructureHttpException
     */
    public function listDoctors(ListExternalDoctorsQuery $query) : ExternalDoctorsCollection
    {
        return new ExternalDoctorsCollection(
            (new ListDoctorsResponse(
                new ListDoctorsDoctorsApiRequest(
                    $query,
                    $this->api_host,
                    $this->username,
                    $this->password
                ),
                $this->http_client
            ))->iterator()
        );
    }

    /**
     * @throws InfrastructureHttpException
     */
    public function listDoctorTimeSlots(ListExternalDoctorTimeSlotsQuery $query) : ExternalDoctorTimeSlotsCollection
    {
        return new ExternalDoctorTimeSlotsCollection(
            (new ListDoctorTimeSlotsResponse(
                new ListDoctorsTimeSlotsRequest(
                    $query,
                    $this->api_host,
                    $this->username,
                    $this->password
                ),
                $this->http_client
            ))->iterator()
        );
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorTimeSlotsQuery;
use Symfony\Component\HttpFoundation\Response;

class ListDoctorsTimeSlotsRequest extends AbstractDoctorsApiRequest implements DoctorsApiRequestInterface
{
    protected int $doctor_id;
    protected ListExternalDoctorTimeSlotsQuery $query;

    public function __construct(ListExternalDoctorTimeSlotsQuery $query, string $host, string $username, string $password)
    {
        parent::__construct($host, $username, $password);
        $this->doctor_id = $query->getDoctorId();
        $this->query = $query;
    }

    public function method() : string
    {
        return 'GET';
    }

    public function path() : string
    {
        return sprintf('api/doctors/%d/slots', $this->doctor_id);
    }

    public function accept() : string
    {
        return 'application/json';
    }

    public function expectCode() : int
    {
        return Response::HTTP_OK;
    }

    public function getDoctorId() : int
    {
        return $this->doctor_id;
    }
}

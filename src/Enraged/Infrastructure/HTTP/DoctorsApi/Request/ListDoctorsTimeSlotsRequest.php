<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorTimeSlotsApiRequestFilter;
use Symfony\Component\HttpFoundation\Response;

class ListDoctorsTimeSlotsRequest extends AbstractDoctorsApiRequest implements DoctorsApiRequestInterface
{
    protected int $doctor_id;
    protected ListDoctorTimeSlotsApiRequestFilter $filter;

    public function __construct(ListDoctorTimeSlotsApiRequestFilter $filter, int $doctorId, string $host, string $username, string $password)
    {
        parent::__construct($host, $username, $password);
        $this->doctor_id = $doctorId;
        $this->filter = $filter;
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

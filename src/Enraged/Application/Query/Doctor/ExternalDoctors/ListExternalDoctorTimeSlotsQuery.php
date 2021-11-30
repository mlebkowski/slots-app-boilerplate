<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors;

class ListExternalDoctorTimeSlotsQuery
{
    protected int $doctorId;

    public function __construct(int $doctorId)
    {
        $this->doctorId = $doctorId;
    }

    public function getDoctorId() : int
    {
        return $this->doctorId;
    }
}

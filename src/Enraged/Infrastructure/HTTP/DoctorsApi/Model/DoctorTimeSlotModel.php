<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Model;

use DateTimeInterface;
use Enraged\Infrastructure\Assertion\InfrastructureAssertion;

class DoctorTimeSlotModel
{
    protected DateTimeInterface $start;
    protected DateTimeInterface $end;
    protected int $doctorId;

    public function __construct(int $doctorId, DateTimeInterface $start, DateTimeInterface $end)
    {
        InfrastructureAssertion::greaterOrEqualThan($doctorId, 0);
        InfrastructureAssertion::greaterThan($end->getTimestamp(), $start->getTimestamp());
        $this->start = $start;
        $this->end = $end;
        $this->doctorId = $doctorId;
    }

    public function getStart() : DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd() : DateTimeInterface
    {
        return $this->end;
    }

    public function getDoctorId() : int
    {
        return $this->doctorId;
    }
}

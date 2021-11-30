<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors\Model;

use DateTimeInterface;
use Enraged\Application\Assertion\ApplicationAssertion;

class ExternalDoctorTimeSlotModel
{
    protected DateTimeInterface $start;
    protected DateTimeInterface $end;
    protected int $externalDoctorId;

    public function __construct(int $externalDoctorId, DateTimeInterface $start, DateTimeInterface $end)
    {
        ApplicationAssertion::greaterOrEqualThan($externalDoctorId, 0);
        ApplicationAssertion::greaterThan($end->getTimestamp(), $start->getTimestamp());
        $this->start = $start;
        $this->end = $end;
        $this->externalDoctorId = $externalDoctorId;
    }

    public function getStart() : DateTimeInterface
    {
        return $this->start;
    }

    public function getEnd() : DateTimeInterface
    {
        return $this->end;
    }

    public function getExternalDoctorId() : int
    {
        return $this->externalDoctorId;
    }
}

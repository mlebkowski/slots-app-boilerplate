<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor\Specification;

use DateTimeInterface;
use Enraged\Domain\AbstractSpecification;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Doctor\DoctorTimeSlot;

class NoPastTimeSlotsSpecification extends AbstractSpecification
{
    protected DateTimeInterface $now;

    public function __construct(DateTimeInterface $now)
    {
        $this->now = $now;
    }

    /**
     * @param DoctorTimeSlot $candidate
     */
    public function assertions(mixed $candidate) : void
    {
        DomainAssertion::isInstanceOf($candidate, DoctorTimeSlot::class);
        DomainAssertion::greaterThan($candidate->getStartAt()->getTimestamp(), $this->now->getTimestamp(), 'Time slot starts in the past!');
        DomainAssertion::greaterThan($candidate->getEndAt()->getTimestamp(), $this->now->getTimestamp(), 'Time slot ends in the past!');
    }
}

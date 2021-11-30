<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor\Specification;

use Enraged\Domain\AbstractSpecification;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Doctor\DoctorTimeSlot;

class TimeSlotDurationSpecification extends AbstractSpecification
{
    /**
     * @param DoctorTimeSlot $candidate
     */
    public function assertions(mixed $candidate) : void
    {
        DomainAssertion::isInstanceOf($candidate, DoctorTimeSlot::class);
        $diff = $candidate->getEndAt()->diff($candidate->getStartAt());
        DomainAssertion::true(
            ($diff->y || $diff->m || $diff->d || $diff->h || ($diff->i > 30) || ($diff->s > 30 * 60)),
            'Time slot shorter than 30 min.'
        );
    }
}

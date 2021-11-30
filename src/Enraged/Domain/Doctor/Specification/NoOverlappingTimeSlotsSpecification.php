<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor\Specification;

use Enraged\Domain\AbstractSpecification;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Doctor\DoctorTimeSlot;

class NoOverlappingTimeSlotsSpecification extends AbstractSpecification
{
    /**
     * @param DoctorTimeSlot[] $candidate
     */
    public function assertions(mixed $candidate) : void
    {
        DomainAssertion::allIsInstanceOf($candidate, DoctorTimeSlot::class);
        DomainAssertion::eq(
            count($candidate),
            count(
                $simplified = array_reduce(
                    $candidate,
                    function (array $accumulator, DoctorTimeSlot $time_slot) {
                        $accumulator[$time_slot->getStartAt()->getTimestamp()] = $time_slot->getEndAt()->getTimestamp();

                        return $accumulator;
                    },
                    []
                )
            ),
            'There are time slots starting at the same time!'
        );
        ksort($simplified, SORT_NUMERIC);
        $last_end_timestamp = 0;
        foreach ($simplified as $start_timestamp => $end_timestamp) {
            DomainAssertion::greaterThan(
                $start_timestamp,
                $last_end_timestamp,
                'There are overlapping timeslots!'
            );
            $last_end_timestamp = $end_timestamp;
        }
    }
}

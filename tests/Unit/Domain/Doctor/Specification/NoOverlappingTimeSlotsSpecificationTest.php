<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor\Specification;

use DateInterval;
use DateTimeImmutable;
use Enraged\Domain\Doctor\Specification\NoOverlappingTimeSlotsSpecification;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorTimeSlotMother;
use PHPUnit\Framework\TestCase;
use stdClass;

class NoOverlappingTimeSlotsSpecificationTest extends TestCase
{
    public function test_rejects_on_elements_that_are_not_time_slot()
    {
        $this->assertFalse((new NoOverlappingTimeSlotsSpecification())->isSatisfiedBy(
            [
                new stdClass(),
            ]
        ));
    }

    public function test_accepts_non_overlapping_time_slots()
    {
        $now = new DateTimeImmutable();
        $this->assertTrue((new NoOverlappingTimeSlotsSpecification())->isSatisfiedBy(
            [
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H'))
                ),
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT2H1S')),
                    $now->add(new DateInterval('PT3H'))
                ),
            ]
        ));
    }

    public function test_reject_completely_overlapping_time_slots()
    {
        $now = new DateTimeImmutable();
        $this->assertFalse((new NoOverlappingTimeSlotsSpecification())->isSatisfiedBy(
            [
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H'))
                ),
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H'))
                ),
            ]
        ));
    }

    public function test_reject_partially_overlapping_time_slots()
    {
        $now = new DateTimeImmutable();
        $this->assertFalse((new NoOverlappingTimeSlotsSpecification())->isSatisfiedBy(
            [
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H'))
                ),
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H30M')),
                    $now->add(new DateInterval('PT2H'))
                ),
            ]
        ));
    }

    public function test_reject_partially_overlapping_time_slots_disregarding_order()
    {
        $now = new DateTimeImmutable();
        $this->assertFalse((new NoOverlappingTimeSlotsSpecification())->isSatisfiedBy(
            [
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H30M')),
                    $now->add(new DateInterval('PT2H'))
                ),
                DoctorTimeSlotMother::createTimeSlot(
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H'))
                ),
            ]
        ));
    }
}

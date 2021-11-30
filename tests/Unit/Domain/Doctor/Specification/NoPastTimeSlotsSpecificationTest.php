<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor\Specification;

use DateInterval;
use DateTimeImmutable;
use Enraged\Domain\Doctor\Specification\NoPastTimeSlotsSpecification;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorTimeSlotMother;
use PHPUnit\Framework\TestCase;

class NoPastTimeSlotsSpecificationTest extends TestCase
{
    public function test_rejects_time_slots_ending_in_the_past()
    {
        $this->assertFalse(
            (new NoPastTimeSlotsSpecification($now = new DateTimeImmutable()))
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now->sub(new DateInterval('PT1H')),
                        $now->sub(new DateInterval('PT30M')),
                    )
                )
        );
    }

    public function test_rejects_time_slots_starting_in_the_past()
    {
        $this->assertFalse(
            (new NoPastTimeSlotsSpecification($now = new DateTimeImmutable()))
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now->sub(new DateInterval('PT1H')),
                        $now->add(new DateInterval('PT1H')),
                    )
                )
        );
    }

    public function test_accepts_time_slots_in_the_future()
    {
        $this->assertTrue(
            (new NoPastTimeSlotsSpecification($now = new DateTimeImmutable()))
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now->add(new DateInterval('PT1H')),
                        $now->add(new DateInterval('PT2H')),
                    )
                )
        );
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor\Specification;

use DateInterval;
use DateTimeImmutable;
use Enraged\Domain\Doctor\Specification\TimeSlotDurationSpecification;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorTimeSlotMother;
use PHPUnit\Framework\TestCase;

class TimeSlotDurationSpecificationTest extends TestCase
{
    public function test_accepts_time_slots_longer_than_30min_by_an_hour()
    {
        $this->assertTrue(
            (new TimeSlotDurationSpecification())
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now = new DateTimeImmutable(),
                        $now->add(new DateInterval('PT1H'))
                    )
                )
        );
    }

    public function test_accepts_time_slots_longer_than_30min_by_an_minute()
    {
        $this->assertTrue(
            (new TimeSlotDurationSpecification())
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now = new DateTimeImmutable(),
                        $now->add(new DateInterval('PT31M'))
                    )
                )
        );
    }

    public function test_accepts_time_slots_longer_than_30min_by_an_second()
    {
        $this->assertTrue(
            (new TimeSlotDurationSpecification())
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now = new DateTimeImmutable(),
                        $now->add(new DateInterval('PT3601S'))
                    )
                )
        );
    }

    public function test_rejects_time_slots_shorter_than_30min()
    {
        $this->assertFalse(
            (new TimeSlotDurationSpecification())
                ->isSatisfiedBy(
                    DoctorTimeSlotMother::createTimeSlot(
                        $now = new DateTimeImmutable(),
                        $now->add(new DateInterval('PT29M'))
                    )
                )
        );
    }
}

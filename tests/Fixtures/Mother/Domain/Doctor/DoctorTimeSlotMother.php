<?php

declare(strict_types=1);

namespace Enraged\Tests\Fixtures\Mother\Domain\Doctor;

use DateTimeInterface;
use Enraged\Domain\Doctor\DoctorTimeSlot;
use Enraged\Tests\Fixtures\Stub\Infrastructure\Calendar\CalendarStub;
use Enraged\Values\Ulid;

class DoctorTimeSlotMother
{
    public static function createTimeSlot(DateTimeInterface $start, DateTimeInterface $end) : DoctorTimeSlot
    {
        return new DoctorTimeSlot(
            new Ulid($calendar = new CalendarStub()),
            new Ulid($calendar),
            $start,
            $end,
            $calendar->now()
        );
    }

    public static function createDoctorTimeSlot(Ulid $doctor_id, DateTimeInterface $start, DateTimeInterface $end) : DoctorTimeSlot
    {
        return new DoctorTimeSlot(
            new Ulid($calendar = new CalendarStub()),
            $doctor_id,
            $start,
            $end,
            $calendar->now()
        );
    }
}

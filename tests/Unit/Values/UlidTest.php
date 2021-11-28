<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Values;

use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Calendar\CalendarInterface;
use Enraged\Tests\Unit\UnitTestCase;
use Enraged\Values\Ulid;

class UlidTest extends UnitTestCase
{
    public function test_new_ulid_takes_into_account_calendar_offset()
    {
        $date_time_immutable = new DateTimeImmutable();
        $calendar = new class($date_time_immutable) implements CalendarInterface {
            protected DateTimeImmutable $date_time_immutable;

            public function __construct(DateTimeImmutable $date_time_immutable)
            {
                $this->date_time_immutable = $date_time_immutable;
            }

            public function now() : DateTimeInterface
            {
                return $this->date_time_immutable;
            }
        };
        $this->assertEquals(
            $date_time_immutable->format(DateTimeInterface::ISO8601),
            (new Ulid($calendar))->getDateTime()->format(DateTimeInterface::ISO8601)
        );
    }
}

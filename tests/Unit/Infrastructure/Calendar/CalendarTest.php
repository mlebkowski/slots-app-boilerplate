<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Infrastructure\Calendar;

use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Calendar\Calendar;
use Enraged\Tests\Unit\UnitTestCase;

class CalendarTest extends UnitTestCase
{
    public function test_returns_current_date_and_time()
    {
        $this->assertEquals(
            (new DateTimeImmutable())->format(DateTimeInterface::ISO8601),
            (new Calendar())->now()->format(DateTimeInterface::ISO8601)
        );
    }
}

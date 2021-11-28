<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Calendar;

use DateInterval;

interface InMemoryCalendarInterface extends CalendarInterface
{
    public function subOffset(DateInterval $offset) : self;

    public function addOffset(DateInterval $offset) : self;

    public function clearOffset() : self;
}

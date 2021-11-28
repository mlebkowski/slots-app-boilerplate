<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Calendar;

use DateTimeInterface;

interface CalendarInterface
{
    public function now() : DateTimeInterface;
}

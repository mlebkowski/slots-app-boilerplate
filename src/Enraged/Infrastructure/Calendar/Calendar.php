<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Calendar;

use DateTimeImmutable;
use DateTimeInterface;

class Calendar implements CalendarInterface
{
    public function now() : DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}

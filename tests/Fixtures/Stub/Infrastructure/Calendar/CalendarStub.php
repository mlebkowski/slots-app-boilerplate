<?php

declare(strict_types=1);

namespace Enraged\Tests\Fixtures\Stub\Infrastructure\Calendar;

use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Calendar\CalendarInterface;

class CalendarStub implements CalendarInterface
{
    protected ?DateTimeInterface $now;

    public function __construct(DateTimeInterface $now = null)
    {
        $this->now = $now;
    }

    public function now() : DateTimeInterface
    {
        return $this->now ?? new DateTimeImmutable();
    }
}

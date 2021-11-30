<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Calendar;

use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Assertion\InfrastructureAssertion;

class Calendar implements CalendarInterface
{
    private const ACCEPTED_TIMEZONE = 'UTC';

    public function __construct()
    {
        InfrastructureAssertion::eq(
            date_default_timezone_get(),
            self::ACCEPTED_TIMEZONE,
            'System timezone other than UTC.'
        );
    }

    public function now() : DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Calendar;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Assertion\InfrastructureAssertion;

final class InMemoryCalendar implements InMemoryCalendarInterface
{
    private const OFFSET_ALREADY_SET_MESSAGE = 'Offset needs to be cleared before setting another.';
    private ?DateInterval $subOffset = null;
    private ?DateInterval $addOffset = null;

    public function __construct()
    {
        InfrastructureAssertion::eq(
            date_default_timezone_get(),
            'UTC',
            'System timezone other than UTC.'
        );
    }

    public function now() : DateTimeInterface
    {
        $now = new DateTimeImmutable();
        if ($this->addOffset) {
            $now = $now->add($this->addOffset);
        }
        if ($this->subOffset) {
            $now = $now->sub($this->subOffset);
        }

        return $now;
    }

    public function subOffset(DateInterval $offset) : self
    {
        InfrastructureAssertion::null($this->addOffset, self::OFFSET_ALREADY_SET_MESSAGE);
        InfrastructureAssertion::null($this->subOffset, self::OFFSET_ALREADY_SET_MESSAGE);
        $this->subOffset = $offset;

        return $this;
    }

    public function addOffset(DateInterval $offset) : self
    {
        InfrastructureAssertion::null($this->addOffset, self::OFFSET_ALREADY_SET_MESSAGE);
        InfrastructureAssertion::null($this->subOffset, self::OFFSET_ALREADY_SET_MESSAGE);
        $this->addOffset = $offset;

        return $this;
    }

    public function clearOffset() : self
    {
        $this->addOffset = null;
        $this->subOffset = null;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Values;

use Enraged\Infrastructure\Calendar\CalendarInterface;

class Ulid extends \Symfony\Component\Uid\Ulid
{
    public function __construct(CalendarInterface $calendar)
    {
        parent::__construct(\Symfony\Component\Uid\Ulid::generate($calendar->now()));
    }
}

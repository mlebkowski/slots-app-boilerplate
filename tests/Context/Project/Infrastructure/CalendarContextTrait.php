<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project\Infrastructure;

use Enraged\Infrastructure\Calendar\CalendarInterface;
use Enraged\Infrastructure\Calendar\InMemoryCalendarInterface;
use RuntimeException;

trait CalendarContextTrait
{
    public function calendar() : InMemoryCalendarInterface
    {
        if (!(($calendar = $this->getContainer()->get(CalendarInterface::class)) instanceof InMemoryCalendarInterface)) {
            throw new RuntimeException('One does not use live calendar when testing.');
        }

        return $calendar;
    }
}

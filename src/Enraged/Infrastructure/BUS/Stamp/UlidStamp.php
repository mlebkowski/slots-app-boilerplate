<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\BUS\Stamp;

use Enraged\Infrastructure\Calendar\CalendarInterface;
use Enraged\Values\Ulid;
use Symfony\Component\Messenger\Stamp\StampInterface;

class UlidStamp implements StampInterface
{
    private string $ulid;

    public function __construct(CalendarInterface $calendar)
    {
        $this->ulid = (string) (new Ulid($calendar));
    }

    public function getUlid() : string
    {
        return $this->ulid;
    }
}

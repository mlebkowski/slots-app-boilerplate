<?php

declare(strict_types=1);

namespace App\ValueObject;

use DateTime;

final class ListSlotsRequest
{
    private string $sortType;
    private DateTime $dateFrom;
    private DateTime $dateTo;
    public function __construct(string $sortType, DateTime $dateFrom, DateTime $dateTo)
    {
        $this->sortType = $sortType;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function getSortType(): string
    {
        return $this->sortType;
    }

    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }
}

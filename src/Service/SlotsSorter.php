<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\SlotsCollection;

interface SlotsSorter
{
    public function sort(SlotsCollection $slotsCollection): SlotsCollection;
}

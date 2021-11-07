<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Slot;
use App\ValueObject\SlotsCollection;

final class ClosestAvailableSlotSorter implements SlotsSorter
{
    public function getName(): string
    {
        return 'closestAvailable';
    }

    public function sort(SlotsCollection $slotsCollection): SlotsCollection
    {
        $slots = $slotsCollection->getSlots();
        usort($slots, function (Slot $item1, Slot $item2) {
            return $item1->getDateFrom() <=> $item2->getDateFrom();
        });
        $slotsCollection->setSlots($slots);

        return $slotsCollection;
    }
}

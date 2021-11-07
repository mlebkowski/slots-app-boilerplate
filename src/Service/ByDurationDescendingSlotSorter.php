<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Slot;
use App\ValueObject\SlotsCollection;

class ByDurationDescendingSlotSorter implements SlotsSorter
{
    public function sort(SlotsCollection $slotsCollection): SlotsCollection
    {
        $slots = $slotsCollection->getSlots();
        usort($slots, function (Slot $item1, Slot $item2) {
            return $this->calculateDuration($item1) <=> $this->calculateDuration($item2);
        });
        $slotsCollection->setSlots($slots);

        return $slotsCollection;
    }

    private function calculateDuration(Slot $slot): int
    {
        return $slot->getDateTo()->getTimestamp() - $slot->getDateFrom()->getTimestamp();
    }
}

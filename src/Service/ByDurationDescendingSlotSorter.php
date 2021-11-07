<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Slot;
use App\ValueObject\SlotsCollection;

final class ByDurationDescendingSlotSorter implements SlotsSorter
{
    public function getName(): string
    {
        return 'durationDescending';
    }

    public function sort(SlotsCollection $slotsCollection): SlotsCollection
    {
        $slots = $slotsCollection->getSlots();
        usort($slots, function (Slot $item1, Slot $item2) {
            return $this->calculateDuration($item2) <=> $this->calculateDuration($item1);
        });
        $slotsCollection->setSlots($slots);

        return $slotsCollection;
    }

    private function calculateDuration(Slot $slot): int
    {
        return abs($slot->getDateTo()->getTimestamp() - $slot->getDateFrom()->getTimestamp());
    }
}

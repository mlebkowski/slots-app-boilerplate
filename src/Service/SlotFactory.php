<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Slot;

class SlotFactory
{
    public static function fromArray(array $slotData, int $doctorId): Slot
    {
        $slot = new Slot();
        $slot->setDateFrom(new \DateTimeImmutable($slotData['start']));
        $slot->setDateTo(new \DateTimeImmutable($slotData['end']));
        $slot->setDoctorId($doctorId);

        return $slot;
    }
}

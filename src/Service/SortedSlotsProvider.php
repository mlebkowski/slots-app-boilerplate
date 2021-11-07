<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\SortingMethodNotFound;
use App\Repository\SlotRepository;
use App\ValueObject\SlotsCollection;

class SortedSlotsProvider
{
    private iterable $slotSorters;
    private SlotRepository $slotRepository;

    public function __construct(iterable $slotSorters, SlotRepository $slotRepository)
    {
        $this->slotSorters = $slotSorters;
        $this->slotRepository = $slotRepository;
    }

    public function getSortedSlotsFromTimeframe(\DateTimeInterface $from, \DateTimeInterface $to, string $sortType): SlotsCollection
    {
        $slotsArray = $this->slotRepository->findInTimeframe($from, $to);
        $slotsCollection = new SlotsCollection();
        $slotsCollection->setSlots($slotsArray);
        foreach ($this->slotSorters as $sorter) {
            if ($sorter->getName() === $sortType) {
                return $sorter->sort($slotsCollection);
            }
        }

        throw new SortingMethodNotFound($sortType.' algorithm was not found');
    }
}

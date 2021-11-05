<?php

namespace App\Tests\Service;

use App\Exception\SlotsSorter\TooManySlotsException;
use App\Service\VeryLazySlotsSorter;

class VeryLazySlotSorterTest extends AbstractSlotSorterTest
{
    /**
     * @dataProvider activeEnoughProvider
     */
    public function testItDoesNothingToSlots($activeness, $slotsCount): void
    {
        $sorter = new VeryLazySlotsSorter($activeness);
        $collection = $this->createSlotsCollection($slotsCount);

        $slotsArray = $collection->getSlots();
        $sortedSlotsArray = $sorter->sort($collection);

        $misplacedSlots = 0;
        foreach ($slotsArray as $i => $item) {
            if ($item->getId() !== $sortedSlotsArray->getSlots()[$i]->getId()) {
                $misplacedSlots++;
            }
        }

        $this->assertEquals(0, $misplacedSlots);
    }

    /**
     * @dataProvider notActiveEnoughProvider
     */
    public function testItThrowsExceptionWhenIsTooLazyToHandleSlots($activeness, $slotsCount): void
    {
        $this->expectException(TooManySlotsException::class);

        $sorter = new VeryLazySlotsSorter($activeness);
        $collection = $this->createSlotsCollection($slotsCount);

        $sorter->sort($collection);
    }

    public function activeEnoughProvider(): array
    {
        return [
            [5, 3],
            [8, 7],
            [4, 1]
        ];
    }

    public function notActiveEnoughProvider(): array
    {
        return [
            [3, 5],
            [7, 8],
            [1, 4]
        ];
    }
}

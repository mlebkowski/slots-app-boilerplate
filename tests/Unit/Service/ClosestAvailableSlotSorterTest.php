<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Slot;
use App\Service\ClosestAvailableSlotSorter;
use App\ValueObject\SlotsCollection;
use PHPUnit\Framework\TestCase;

class ClosestAvailableSlotSorterTest extends TestCase
{
    /**
     * @dataProvider slotStartDateStringsProvider
     */
    public function testSortingFromClosestAvailableToLatest(array $slotStartDates): void
    {
        //arrange
        $slots = $this->createSlotCollectionWhereSlotsStartingAt($slotStartDates);
        $sorter = new ClosestAvailableSlotSorter();

        //act
        $sorted = $sorter->sort($slots);

        //assert
        self::assertOrderedByClosestAvailable($sorted);
    }

    private static function assertOrderedByClosestAvailable(SlotsCollection $collection)
    {
        $slots = $collection->getSlots();
        foreach ($slots as $slot) {
            if (!isset($last)) {
                $last = $slot;
                continue;
            }
            if ($slot->getDateFrom() > $last->getDateFrom()) {
                self::fail('Order is not matching in at least one case in set');
            }
        }
        self::assertTrue(true);
    }

    private function createSlotCollectionWhereSlotsStartingAt(array $slotStartDates): SlotsCollection
    {
        $slots = new SlotsCollection();
        foreach ($slotStartDates as $startDate) {
            $slot = new Slot();
            $slot->setDateFrom(new \DateTimeImmutable($startDate));
            $slots->addSlot($slot);
        }
        return $slots;
    }

    public function slotStartDateStringsProvider(): array
    {
        return [
            [
                ['2020-02-02T15:40:00+00:00'],
                ['1998-02-01T17:00:00+00:00'],
                ['2020-02-01T15:30:00+00:00'],
                ['2138-02-07T15:40:00+00:00'],
                ['2020-02-07T15:40:00+00:00'],
                ['2019-02-07T15:40:00+00:00'],
            ],
            [
                ['2020-02-07T15:40:00+00:00'],
                ['2020-02-07T15:40:00+00:00'],
                ['2020-02-07T15:40:00+00:00'],
            ],
        ];
    }
}

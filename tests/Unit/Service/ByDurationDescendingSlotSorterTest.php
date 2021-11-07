<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Slot;
use App\Service\ByDurationDescendingSlotSorter;
use App\ValueObject\SlotsCollection;
use PHPUnit\Framework\TestCase;

class ByDurationDescendingSlotSorterTest extends TestCase
{
    private const BASE_DATE = '2021-01-01T00:00:00+00:00';

    /**
     * @dataProvider slotDurationsProvider
     */
    public function testDurationIsDescending(array $durations): void
    {
        //arrange
        $collection = $this->getCollectionOfSlotsWithDuration($durations);
        $sorter = new ByDurationDescendingSlotSorter();

        //act
        $sorted = $sorter->sort($collection);

        //assert
        self::assertSlotsOrderedFromLongestToShortest($sorted);
    }

    private static function assertSlotsOrderedFromLongestToShortest(SlotsCollection $collection): void
    {
        $slots = $collection->getSlots();
        foreach ($slots as $slot) {
            if (!isset($last)) {
                $last = $slot;
                continue;
            }
            if (self::calculateDuration($slot) > self::calculateDuration($last)) {
                self::fail('Order is not matching in at least one case in set');
            }
        }
        self::assertTrue(true);
    }

    private static function calculateDuration(Slot $slot): int
    {
        return abs($slot->getDateTo()->getTimestamp() - $slot->getDateFrom()->getTimestamp());
    }

    /**
     * @return array[['duration']]
     */
    public function slotDurationsProvider(): array
    {
        return [
            [['+3 hours', '+1 hour', '+2 hours', '+5 hours', '+6 hours', '-20 minutes']], //last for check when data not valid
            [['+3 hours', '+2 days', '+5 seconds', '+0 seconds', '+7 years']],
            [['+3 hours', '+3 hours', '+3 hours']]
        ];
    }

    private function getCollectionOfSlotsWithDuration(array $durations): SlotsCollection
    {
        $slotCollection = new SlotsCollection();
        foreach ($durations as $duration) {
            $slot = new Slot();
            $start = new \DateTimeImmutable(self::BASE_DATE);
            $slot->setDateFrom($start);
            $slot->setDateTo($start->modify($duration));
            $slotCollection->addSlot($slot);
        }
        return $slotCollection;
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Infrastructure\Calendar;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\Calendar\InMemoryCalendar;
use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;
use Enraged\Tests\Unit\UnitTestCase;

class InMemoryCalendarTest extends UnitTestCase
{
    public function test_returns_current_date_and_time()
    {
        $this->assertEquals(
            (new DateTimeImmutable())->format(DateTimeInterface::ISO8601),
            (new InMemoryCalendar())->now()->format(DateTimeInterface::ISO8601)
        );
    }

    public function test_subtracts_provided_offset()
    {
        $this->assertEquals(
            (new DateTimeImmutable())
                ->sub($offset = new DateInterval('P1D'))
                ->format(DateTimeInterface::ISO8601),
            (new InMemoryCalendar())
                ->subOffset($offset)
                ->now()
                ->format(DateTimeInterface::ISO8601)
        );
    }

    public function test_adds_provided_offset()
    {
        $this->assertEquals(
            (new DateTimeImmutable())
                ->add($offset = new DateInterval('P1D'))
                ->format(DateTimeInterface::ISO8601),
            (new InMemoryCalendar())
                ->addOffset($offset)
                ->now()
                ->format(DateTimeInterface::ISO8601)
        );
    }

    public function test_subtracted_offset_needs_to_be_cleared_before_subtracting_another()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        (new InMemoryCalendar())
            ->subOffset(new DateInterval('P1D'))
            ->subOffset(new DateInterval('PT1H'));
    }

    public function test_subtracted_offset_needs_to_be_cleared_before_adding_another()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        (new InMemoryCalendar())
            ->subOffset(new DateInterval('P1D'))
            ->addOffset(new DateInterval('PT1H'));
    }

    public function test_added_offset_needs_to_be_cleared_before_subtracting_another()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        (new InMemoryCalendar())
            ->addOffset(new DateInterval('P1D'))
            ->subOffset(new DateInterval('PT1H'));
    }

    public function test_added_offset_needs_to_be_cleared_before_adding_another()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        (new InMemoryCalendar())
            ->addOffset(new DateInterval('P1D'))
            ->addOffset(new DateInterval('PT1H'));
    }

    public function test_clearing_added_offset()
    {
        $this->assertEquals(
            (new DateTimeImmutable())->format(DateTimeInterface::ISO8601),
            (new InMemoryCalendar())
                ->addOffset(new DateInterval('P1D'))
                ->clearOffset()
                ->now()
                ->format(DateTimeInterface::ISO8601)
        );
    }

    public function test_clearing_subtracted_offset()
    {
        $this->assertEquals(
            (new DateTimeImmutable())->format(DateTimeInterface::ISO8601),
            (new InMemoryCalendar())
                ->subOffset(new DateInterval('P1D'))
                ->clearOffset()
                ->now()
                ->format(DateTimeInterface::ISO8601)
        );
    }
}

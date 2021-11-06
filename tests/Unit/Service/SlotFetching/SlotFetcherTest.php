<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\SlotFetching;

use App\Entity\Slot;
use App\Exception\SlotFetcher\SlotsFetchingException;
use App\Repository\SlotPersister;
use App\Service\SlotFetching\DoctorFetchingClient;
use App\Service\SlotFetching\SlotFetchingClient;
use App\Service\SlotFetching\SlotsFetcher;
use App\ValueObject\SlotsCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;

class SlotFetcherTest extends TestCase
{
    private ObjectProphecy|LoggerInterface $logger;
    private ObjectProphecy|SlotFetchingClient $slotFetchingClient;
    private ObjectProphecy|DoctorFetchingClient $doctorFetchingClient;
    private ObjectProphecy|SlotPersister $slotPersister;
    private SlotsFetcher $fetcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->slotFetchingClient = $this->prophesize(SlotFetchingClient::class);
        $this->doctorFetchingClient = $this->prophesize(DoctorFetchingClient::class);
        $this->slotPersister = $this->prophesize(SlotPersister::class);
        $this->fetcher = new SlotsFetcher(
            $this->logger->reveal(),
            $this->doctorFetchingClient->reveal(),
            $this->slotFetchingClient->reveal(),
            $this->slotPersister->reveal()
        );
    }

    public function testSuccessfulFetch(): void
    {
        $this->doctorFetchingClient->getDoctorIds()
            ->shouldBeCalledOnce()
            ->willReturn([1,2]);

        $firstCollection = new SlotsCollection();
        $secondCollection = new SlotsCollection();
        $secondCollection->addSlot(new Slot());

        $this->slotFetchingClient->getSlotsByDoctorId(1)
            ->shouldBeCalledOnce()
            ->willReturn($firstCollection);

        $this->slotPersister->persistCollection($firstCollection)
            ->shouldBeCalledOnce();

        $this->slotFetchingClient->getSlotsByDoctorId(2)
            ->shouldBeCalledOnce()
            ->willReturn($secondCollection);

        $this->slotPersister->persistCollection($secondCollection)
            ->shouldBeCalledOnce();

        $this->fetcher->fetch();
    }

    public function testLogsErrorWhenExceptionThrownBySlotFetchingClient(): void
    {
        $this->doctorFetchingClient->getDoctorIds()
            ->shouldBeCalledOnce()
            ->willReturn([1]);

        $this->slotFetchingClient->getSlotsByDoctorId(1)
            ->shouldBeCalledOnce()
            ->willThrow(SlotsFetchingException::class);

        $this->fetcher->fetch();

        $this->logger->error(Argument::any())->shouldHaveBeenCalled();
    }
}

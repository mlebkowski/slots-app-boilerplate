<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\SlotFetcher\SlotsFetchingException;
use App\Repository\SlotPersister;
use Psr\Log\LoggerInterface;

class SlotsFetcher
{
    private DoctorFetchingClient $doctorFetchingClient;
    private SlotFetchingClient $slotFetchingClient;
    private SlotPersister $slotPersister;
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        DoctorFetchingClient $doctorFetchingClient,
        SlotFetchingClient $slotFetchingClient,
        SlotPersister $slotPersister
    ) {
        $this->doctorFetchingClient = $doctorFetchingClient;
        $this->slotFetchingClient = $slotFetchingClient;
        $this->slotPersister = $slotPersister;
        $this->logger = $logger;
    }

    public function fetch(): void
    {
        $doctorIds = $this->doctorFetchingClient->getDoctorIds();

        foreach ($doctorIds as $doctorId) {
            try {
                $slots = $this->slotFetchingClient->getSlotsByDoctorId($doctorId);
            } catch (SlotsFetchingException $exception) {
                $this->logger->error($exception->getMessage());
            }
            $this->slotPersister->persistCollection($slots);
        }
    }
}

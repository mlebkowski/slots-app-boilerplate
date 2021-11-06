<?php

declare(strict_types=1);

namespace App\Service\SlotFetching;

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

    /**
     * TODO: Add communication if action was performed successfully
     */
    public function fetch(): void
    {
        $doctorIds = $this->doctorFetchingClient->getDoctorIds();

        foreach ($doctorIds as $doctorId) {
            /**
             * TODO: Interior of this loop should be refactored into sending some kind of fetchSlotsForDoctor messages,
             * as probably there would be more doctors with more slots in the future
            */
            try {
                $slots = $this->slotFetchingClient->getSlotsByDoctorId($doctorId);
            } catch (SlotsFetchingException $exception) {
                $this->logger->error($exception->getMessage());
            }
            if (isset($slots)) {
                $this->slotPersister->persistCollection($slots);
            }
        }
    }
}

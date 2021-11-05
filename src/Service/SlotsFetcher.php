<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlotsFetcher
{
    private HttpClientInterface $slotsApiClient;
    private DoctorFetchingClient $doctorFetchingClient;
    private SlotFetchingClient $slotFetchingClient;
    private EntityManagerInterface $entityManager;

    public function __construct(
        HttpClientInterface $slotsApiClient,
        DoctorFetchingClient $doctorFetchingClient,
        SlotFetchingClient $slotFetchingClient,
        EntityManagerInterface $entityManager
    ) {
        $this->slotsApiClient = $slotsApiClient;
        $this->doctorFetchingClient = $doctorFetchingClient;
        $this->slotFetchingClient = $slotFetchingClient;
        $this->entityManager = $entityManager;
    }

    public function fetch(): void
    {
        $doctorIds = $this->doctorFetchingClient->getDoctorIds();

        foreach ($doctorIds as $doctorId) {
            $doctorSlots = $this->slotFetchingClient->fetchSlotsByDoctorId($doctorId);
            foreach ($doctorSlots->getSlots() as $slot) {
                $this->entityManager->persist($slot);
            }
            $this->entityManager->flush();
        }
    }
}

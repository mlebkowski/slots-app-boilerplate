<?php

declare(strict_types=1);

namespace App\Service\SlotFetching;

use App\Entity\Slot;
use App\Exception\SlotFetcher\SlotsFetchingException;
use App\ValueObject\SlotsCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlotFetchingClient
{
    private HttpClientInterface $slotsApiClient;

    public function __construct(HttpClientInterface $slotsApiClient)
    {
        $this->slotsApiClient = $slotsApiClient;
    }

    public function getSlotsByDoctorId(int $doctorId): SlotsCollection
    {
        try {
            $rawSlots = $this->getSlotsArrayByDoctorId($doctorId);
        } catch (\Exception $exception) {
            throw SlotsFetchingException::fromDoctorIdAndException($doctorId, $exception);
        }

        $slots = new SlotsCollection();
        foreach ($rawSlots as $slotArray) {
            // TODO: move creation of slots into some kind of factory, which also take care about validation of Slots
            $slot = new Slot();
            $slot->setDateFrom(new \DateTimeImmutable($slotArray['start']));
            $slot->setDateTo(new \DateTimeImmutable($slotArray['end']));
            $slot->setDoctorId($doctorId);
            $slots->addSlot($slot);
        }
        return $slots;
    }

    private function getSlotsArrayByDoctorId(int $doctorId): array
    {
        $slotsResponse = $this->slotsApiClient->request(
            Request::METHOD_GET,
            sprintf('doctors/%s/slots', $doctorId)
        );
        return json_decode($slotsResponse->getContent(), true);
    }
}

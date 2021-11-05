<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\SlotsCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlotFetchingClient
{
    private HttpClientInterface $slotsApiClient;

    public function __construct(HttpClientInterface $slotsApiClient)
    {
        $this->slotsApiClient = $slotsApiClient;
    }

    public function fetchSlotsByDoctorId(int $doctorId): SlotsCollection
    {
        try {
            $slotsResponse = $this->slotsApiClient->request(
                Request::METHOD_GET,
                'doctors/'.$doctorId.'/slots'
            );
        } catch (TransportExceptionInterface $exception) {
            return new SlotsCollection();
        }

        $slots = new SlotsCollection();

        try {
            $rawSlots = json_decode($slotsResponse->getContent(), true);
        } catch (\Exception $exception) {
            return new SlotsCollection();
        }

        foreach ($rawSlots as $slotArray) {
            $slots->addSlot(SlotFactory::fromArray($slotArray, $doctorId));
        }

        return $slots;
    }
}

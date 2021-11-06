<?php

declare(strict_types=1);

namespace App\Repository;

use App\ValueObject\SlotsCollection;
use Doctrine\ORM\EntityManagerInterface;

class SlotPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persistCollection(SlotsCollection $collection): void
    {
        foreach ($collection->getSlots() as $slot) {
            $this->entityManager->persist($slot);
        }
        $this->entityManager->flush();
    }
}

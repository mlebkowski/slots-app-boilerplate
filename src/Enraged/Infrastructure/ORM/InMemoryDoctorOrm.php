<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\ORM;

use Enraged\Domain\Doctor\Doctor;
use Enraged\Domain\Doctor\DoctorInterface;

class InMemoryDoctorOrm implements DoctorInterface
{
    /**
     * @var Doctor[]
     */
    private array $doctors = [];

    public function findByExternalId(int $externalId) : ?Doctor
    {
        foreach ($this->doctors as $doctor) {
            if ($doctor->getExternalId() === $externalId) {
                return $doctor;
            }
        }

        return null;
    }

    public function persist(Doctor $doctor) : void
    {
        $this->doctors[(string) $doctor->getId()] = $doctor;
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor;

interface DoctorInterface
{
    public function findByExternalId(int $externalId) : ?Doctor;

    public function persist(Doctor $doctor) : void;
}

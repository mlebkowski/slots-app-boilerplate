<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\ORM;

use Enraged\Domain\Doctor\Doctor;
use Enraged\Domain\Doctor\DoctorInterface;
use Enraged\Infrastructure\Exception\InfrastructureNotImplementedException;

class DoctorOrm implements DoctorInterface
{
    public function findByExternalId(int $externalId) : ?Doctor
    {
        throw new InfrastructureNotImplementedException();
    }

    public function persist(Doctor $doctor) : void
    {
        throw new InfrastructureNotImplementedException();
    }
}

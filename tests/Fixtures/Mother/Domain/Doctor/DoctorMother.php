<?php

declare(strict_types=1);

namespace Enraged\Tests\Fixtures\Mother\Domain\Doctor;

use DateTimeImmutable;
use Enraged\Domain\Doctor\Doctor;
use Enraged\Domain\Doctor\Specification\DoctorNameSpecification;
use Enraged\Domain\Doctor\Specification\DoctorUniqueExternalIdSpecification;
use Enraged\Infrastructure\ORM\InMemoryDoctorOrm;
use Enraged\Tests\Fixtures\Stub\Infrastructure\Calendar\CalendarStub;
use Enraged\Values\Ulid;

class DoctorMother
{
    public static function createDoctor(int $external_id) : Doctor
    {
        return new Doctor(
            new Ulid(new CalendarStub()),
            $external_id,
            'Doctor Who',
            new DateTimeImmutable(),
            new DoctorUniqueExternalIdSpecification(new InMemoryDoctorOrm()),
            new DoctorNameSpecification()
        );
    }
}

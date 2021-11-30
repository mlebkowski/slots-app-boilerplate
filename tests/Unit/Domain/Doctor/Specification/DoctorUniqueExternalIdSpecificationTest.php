<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor\Specification;

use Enraged\Domain\Doctor\Specification\DoctorUniqueExternalIdSpecification;
use Enraged\Infrastructure\ORM\InMemoryDoctorOrm;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorMother;
use PHPUnit\Framework\TestCase;

class DoctorUniqueExternalIdSpecificationTest extends TestCase
{
    public function test_rejects_doctor_with_existing_external_id()
    {
        $doctors = new InMemoryDoctorOrm();
        $doctors->persist(DoctorMother::createDoctor($existing_external_id = 1));
        $this->assertFalse(
            (new DoctorUniqueExternalIdSpecification($doctors))
                ->isSatisfiedBy($existing_external_id)
        );
    }

    public function test_accept_doctor_with_existing_external_id()
    {
        $this->assertTrue(
            (new DoctorUniqueExternalIdSpecification(new InMemoryDoctorOrm()))
                ->isSatisfiedBy(1)
        );
    }
}

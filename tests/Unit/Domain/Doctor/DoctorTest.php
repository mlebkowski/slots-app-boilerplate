<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor;

use DateInterval;
use DateTimeImmutable;
use Enraged\Domain\Doctor\Doctor;
use Enraged\Domain\Doctor\Specification\DoctorNameSpecification;
use Enraged\Domain\Doctor\Specification\DoctorUniqueExternalIdSpecification;
use Enraged\Domain\Doctor\Specification\NoOverlappingTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\NoPastTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\TimeSlotDurationSpecification;
use Enraged\Domain\Exception\DomainInvalidAssertionException;
use Enraged\Infrastructure\ORM\InMemoryDoctorOrm;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorMother;
use Enraged\Tests\Fixtures\Mother\Domain\Doctor\DoctorTimeSlotMother;
use Enraged\Tests\Fixtures\Stub\Infrastructure\Calendar\CalendarStub;
use Enraged\Values\Ulid;
use PHPUnit\Framework\TestCase;

class DoctorTest extends TestCase
{
    public function test_cannot_delete_deleted_doctor()
    {
        $this->expectExceptionObject(new DomainInvalidAssertionException('Domain Object was deleted!', 25));
        $doctor = DoctorMother::createDoctor(1);
        $doctor->delete(new DateTimeImmutable());
        $doctor->delete(new DateTimeImmutable());
    }

    public function test_cannot_update_name_on_deleted_doctor()
    {
        $this->expectExceptionObject(new DomainInvalidAssertionException('Domain Object was deleted!', 38));
        $doctor = DoctorMother::createDoctor(1);
        $doctor->delete(new DateTimeImmutable());
        $doctor->setName('Doctor Moreau', new DoctorNameSpecification(), new DateTimeImmutable());
    }

    public function test_cannot_set_time_slots_on_deleted_doctor()
    {
        $this->expectExceptionObject(new DomainInvalidAssertionException('Domain Object was deleted!', 38));
        $now = new DateTimeImmutable();
        $doctor = DoctorMother::createDoctor(1);
        $doctor->delete(new DateTimeImmutable());
        $doctor->setAvailableTimeslots(
            [
                DoctorTimeSlotMother::createDoctorTimeSlot(
                    $doctor->getId(),
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H')),
                ),
            ],
            new NoPastTimeSlotsSpecification(new DateTimeImmutable()),
            new NoOverlappingTimeSlotsSpecification(),
            new TimeSlotDurationSpecification(),
            new DateTimeImmutable()
        );
    }

    public function test_candidates_has_been_tested_on_creation()
    {
        new Doctor(
            new Ulid(new CalendarStub()),
            $external_id = 1,
            $doctor_name = 'Doctor Who',
            new DateTimeImmutable(),
            $unique_doctor_external_id_specification = new DoctorUniqueExternalIdSpecification(new InMemoryDoctorOrm()),
            $doctor_name_specification = new DoctorNameSpecification()
        );
        $this->assertEquals($external_id, $unique_doctor_external_id_specification->lastCandidate());
        $this->assertEquals($doctor_name, $doctor_name_specification->lastCandidate());
    }

    public function test_candidates_has_been_tested_on_setting_available_time_slots()
    {
        $now = new DateTimeImmutable();
        $doctor = new Doctor(
            new Ulid(new CalendarStub()),
            1,
            'Doctor Who',
            $now,
            new DoctorUniqueExternalIdSpecification(new InMemoryDoctorOrm()),
            new DoctorNameSpecification()
        );
        $doctor->setAvailableTimeslots(
            $slots = [
                $slot = DoctorTimeSlotMother::createDoctorTimeSlot(
                    $doctor->getId(),
                    $now->add(new DateInterval('PT1H')),
                    $now->add(new DateInterval('PT2H')),
                ),
            ],
            $no_past_slots_specification = new NoPastTimeSlotsSpecification($now),
            $no_overlapping_time_slots_specification = new NoOverlappingTimeSlotsSpecification(),
            $time_slot_duration_specification = new TimeSlotDurationSpecification(),
            new DateTimeImmutable()
        );

        $this->assertEquals($slot, $no_past_slots_specification->lastCandidate());
        $this->assertEquals($slots, $no_overlapping_time_slots_specification->lastCandidate());
        $this->assertEquals($slot, $time_slot_duration_specification->lastCandidate());
    }
}

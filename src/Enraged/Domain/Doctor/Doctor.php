<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor;

use DateTimeInterface;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Doctor\Specification\DoctorNameSpecification;
use Enraged\Domain\Doctor\Specification\DoctorUniqueExternalIdSpecification;
use Enraged\Domain\Doctor\Specification\NoOverlappingTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\NoPastTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\TimeSlotDurationSpecification;
use Enraged\Domain\Exception\DomainInvalidAssertionException;
use Enraged\Values\Ulid;

class Doctor
{
    protected Ulid $id;
    protected int $external_id;
    protected string $name;
    protected DateTimeInterface $created_at;
    protected ?DateTimeInterface $updated_at = null;
    protected ?DateTimeInterface $deleted_at = null;
    /**
     * @var DoctorTimeSlot[]
     */
    protected array $available_time_slots;

    public function __construct(
        Ulid $id,
        int $external_id,
        string $name,
        DateTimeInterface $created_at,
        DoctorUniqueExternalIdSpecification $unique_doctor_external_id_specification,
        DoctorNameSpecification $doctor_name_specification
    ) {
        DomainAssertion::true(
            $unique_doctor_external_id_specification->isSatisfiedBy($external_id),
            $unique_doctor_external_id_specification->error()
        );
        DomainAssertion::true(
            $doctor_name_specification->isSatisfiedBy($name),
            $doctor_name_specification->error()
        );
        $this->id = $id;
        $this->external_id = $external_id;
        $this->name = $name;
        $this->created_at = $created_at;
    }

    public function delete(DateTimeInterface $deleted_at) : void
    {
        DomainAssertion::null($this->deleted_at, 'Domain Object was deleted!');
        $this->deleted_at = $deleted_at;
    }

    public function setName(string $name, DoctorNameSpecification $doctor_name_specification, DateTimeInterface $updated_at) : void
    {
        DomainAssertion::false($this->isDeleted(), 'Domain Object was deleted!');
        DomainAssertion::true(
            $doctor_name_specification->isSatisfiedBy($name),
            $doctor_name_specification->error()
        );
        $this->name = $name;
        $this->updated_at = $updated_at;
    }

    public function isDeleted() : bool
    {
        return $this->deleted_at instanceof DateTimeInterface;
    }

    public function getId() : Ulid
    {
        return $this->id;
    }

    public function getExternalId() : int
    {
        return $this->external_id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param DoctorTimeSlot[] $available_time_slots
     *
     * @throws DomainInvalidAssertionException
     */
    public function setAvailableTimeslots(
        array $available_time_slots,
        NoPastTimeSlotsSpecification $no_past_time_slots_specification,
        NoOverlappingTimeSlotsSpecification $no_overlapping_time_slots_specification,
        TimeSlotDurationSpecification $time_slot_duration_specification,
        DateTimeInterface $updated_at
    ) : void {
        DomainAssertion::false($this->isDeleted(), 'Domain Object was deleted!');
        DomainAssertion::allIsInstanceOf($available_time_slots, DoctorTimeSlot::class);
        $future_time_slots = array_filter($available_time_slots, fn (DoctorTimeSlot $slot) => $no_past_time_slots_specification->isSatisfiedBy($slot));
        $future_long_enough_time_slots = array_filter($future_time_slots, fn (DoctorTimeSlot $slot) => $time_slot_duration_specification->isSatisfiedBy($slot));
        DomainAssertion::true(
            $no_overlapping_time_slots_specification->isSatisfiedBy($future_non_overlapping_long_enough_time_slots = $future_long_enough_time_slots),
            $no_overlapping_time_slots_specification->error()
        );
        $this->available_time_slots = $future_non_overlapping_long_enough_time_slots;
        $this->updated_at = $updated_at;
    }

    /**
     * @return DoctorTimeSlot[]
     */
    public function getAvailableTimeSlots() : array
    {
        return $this->available_time_slots;
    }
}

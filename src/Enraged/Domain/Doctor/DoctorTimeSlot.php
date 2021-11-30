<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor;

use DateTimeInterface;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Values\Ulid;

class DoctorTimeSlot
{
    protected Ulid $id;
    protected Ulid $doctor_id;
    protected DateTimeInterface $start_at;
    protected DateTimeInterface $end_at;
    protected DateTimeInterface $created_at;
    protected ?DateTimeInterface $updated_at = null;
    protected ?DateTimeInterface $deleted_at = null;

    public function __construct(
        Ulid $id,
        Ulid $doctor_id,
        DateTimeInterface $start_at,
        DateTimeInterface $end_at,
        DateTimeInterface $created_at
    ) {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        $this->created_at = $created_at;
    }

    public function delete(DateTimeInterface $deleted_at) : void
    {
        DomainAssertion::null($this->deleted_at, 'Domain Object was deleted!');
        $this->deleted_at = $deleted_at;
    }

    public function isDeleted() : bool
    {
        return $this->deleted_at instanceof DateTimeInterface;
    }

    public function getStartAt() : DateTimeInterface
    {
        return $this->start_at;
    }

    public function getEndAt() : DateTimeInterface
    {
        return $this->end_at;
    }
}

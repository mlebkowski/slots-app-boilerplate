<?php

declare(strict_types=1);

namespace Enraged\Application\CommandHandler\Doctor;

use Doctrine\ORM\EntityManagerInterface;
use Enraged\Application\Command\Doctor\SynchronizeDoctorCommand;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotModel;
use Enraged\Domain\Doctor\Doctor;
use Enraged\Domain\Doctor\DoctorInterface;
use Enraged\Domain\Doctor\DoctorTimeSlot;
use Enraged\Domain\Doctor\Specification\DoctorNameSpecification;
use Enraged\Domain\Doctor\Specification\DoctorUniqueExternalIdSpecification;
use Enraged\Domain\Doctor\Specification\NoOverlappingTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\NoPastTimeSlotsSpecification;
use Enraged\Domain\Doctor\Specification\TimeSlotDurationSpecification;
use Enraged\Infrastructure\Calendar\CalendarInterface;
use Enraged\Values\Ulid;

class SynchronizeDoctorHandler
{
    protected CalendarInterface $calendar;
    protected DoctorInterface $doctors;
    protected EntityManagerInterface $entity_manager;

    public function __construct(
        CalendarInterface $calendar,
        DoctorInterface $doctors,
        EntityManagerInterface $entity_manager
    ) {
        $this->calendar = $calendar;
        $this->doctors = $doctors;
        $this->entity_manager = $entity_manager;
    }

    public function __invoke(SynchronizeDoctorCommand $command) : void
    {
        $doctor = $this->doctors->findByExternalId($command->getExternalDoctorId())
            ?? new Doctor(
                new Ulid($this->calendar),
                $command->getExternalDoctorId(),
                $command->getDoctorName(),
                $this->calendar->now(),
                new DoctorUniqueExternalIdSpecification($this->doctors),
                new DoctorNameSpecification()
            );
        if ($doctor->getName() !== $command->getDoctorName()) {
            $doctor->setName(
                $command->getDoctorName(),
                new DoctorNameSpecification(),
                $this->calendar->now()
            );
        }
        $doctor->setAvailableTimeslots(
            array_map(
                function (ExternalDoctorTimeSlotModel $time_slot_model) use ($doctor) : DoctorTimeSlot {
                    return new DoctorTimeSlot(
                        new Ulid($this->calendar),
                        $doctor->getId(),
                        $time_slot_model->getStart(),
                        $time_slot_model->getEnd(),
                        $this->calendar->now()
                    );
                },
                $command->getTimeSlots()
            ),
            new NoPastTimeSlotsSpecification($this->calendar->now()),
            new NoOverlappingTimeSlotsSpecification(),
            new TimeSlotDurationSpecification(),
            $this->calendar->now()
        );
        $this->doctors->persist($doctor);
    }
}

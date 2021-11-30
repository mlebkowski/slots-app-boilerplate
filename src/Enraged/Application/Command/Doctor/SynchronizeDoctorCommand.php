<?php

declare(strict_types=1);

namespace Enraged\Application\Command\Doctor;

use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotModel;

class SynchronizeDoctorCommand
{
    protected int $externalDoctorId;
    protected string $doctorName;
    /**
     * @var ExternalDoctorTimeSlotModel[]
     */
    protected array $timeSlots;

    /**
     * @param ExternalDoctorTimeSlotModel[] $timeSlots
     */
    public function __construct(int $externalDoctorId, string $doctorName, array $timeSlots)
    {
        $this->externalDoctorId = $externalDoctorId;
        $this->doctorName = $doctorName;
        $this->timeSlots = $timeSlots;
    }

    public function getExternalDoctorId() : int
    {
        return $this->externalDoctorId;
    }

    public function getDoctorName() : string
    {
        return $this->doctorName;
    }

    /**
     * @return ExternalDoctorTimeSlotModel[]
     */
    public function getTimeSlots() : array
    {
        return $this->timeSlots;
    }
}

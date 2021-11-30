<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors;

use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorsCollection;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotsCollection;

interface ExternalDoctorsQueryInterface
{
    public function listDoctors(ListExternalDoctorsQuery $query) : ExternalDoctorsCollection;

    public function listDoctorTimeSlots(ListExternalDoctorTimeSlotsQuery $query) : ExternalDoctorTimeSlotsCollection;
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi;

use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorTimeSlotsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorTimeSlotModel;
use Iterator;

interface DoctorsApiInterface
{
    /**
     * @return Iterator<int, DoctorModel>
     */
    public function listDoctors(ListDoctorsApiRequestFilter $filter) : Iterator;

    /**
     * @return Iterator<int, DoctorTimeSlotModel>
     */
    public function listDoctorTimeSlots(ListDoctorTimeSlotsApiRequestFilter $filter, int $doctorExternalId) : Iterator;
}

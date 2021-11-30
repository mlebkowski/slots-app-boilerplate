<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors\Model;

use IteratorIterator;

class ExternalDoctorTimeSlotsCollection extends IteratorIterator
{
    public function key() : int
    {
        return parent::key();
    }

    public function current() : ExternalDoctorTimeSlotModel
    {
        return parent::current();
    }
}

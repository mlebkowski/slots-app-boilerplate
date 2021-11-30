<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors\Model;

use IteratorIterator;

class ExternalDoctorsCollection extends IteratorIterator
{
    public function key() : int
    {
        return parent::key();
    }

    public function current() : ExternalDoctorModel
    {
        return parent::current();
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi;

use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use Iterator;

interface DoctorsApiInterface
{
    /**
     * @return Iterator<int, DoctorModel>
     */
    public function getAllDoctors() : Iterator;
}

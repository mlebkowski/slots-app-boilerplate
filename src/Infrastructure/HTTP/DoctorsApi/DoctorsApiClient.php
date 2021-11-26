<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi;

use Enraged\Infrastructure\Exception\InfrastructureNotImplementedException;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use Iterator;

class DoctorsApiClient implements DoctorsApiInterface
{
    /**
     * @return Iterator<int, DoctorModel>
     */
    public function getAllDoctors() : Iterator
    {
        throw new InfrastructureNotImplementedException();
    }
}

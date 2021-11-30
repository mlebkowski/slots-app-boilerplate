<?php

declare(strict_types=1);

namespace Enraged\Application\Query\Doctor\ExternalDoctors\Model;

use Enraged\Application\Assertion\ApplicationAssertion;

class ExternalDoctorModel
{
    protected int $id;
    protected string $name;

    public function __construct(int $id, string $name)
    {
        ApplicationAssertion::greaterOrEqualThan($id, 0);
        ApplicationAssertion::notEmpty($name);
        $this->id = $id;
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getExternalId() : int
    {
        return $this->id;
    }
}

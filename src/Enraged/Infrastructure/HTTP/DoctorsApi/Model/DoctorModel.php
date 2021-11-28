<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Model;

use Enraged\Infrastructure\Assertion\InfrastructureAssertion;

class DoctorModel
{
    protected int $id;
    protected string $name;

    public function __construct(int $id, string $name)
    {
        InfrastructureAssertion::greaterOrEqualThan($id, 0);
        InfrastructureAssertion::notEmpty($name);
        $this->id = $id;
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getId() : int
    {
        return $this->id;
    }
}

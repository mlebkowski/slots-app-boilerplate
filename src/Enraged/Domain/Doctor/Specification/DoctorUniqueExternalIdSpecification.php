<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor\Specification;

use Enraged\Domain\AbstractSpecification;
use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Doctor\DoctorInterface;

class DoctorUniqueExternalIdSpecification extends AbstractSpecification
{
    protected DoctorInterface $doctors;

    public function __construct(DoctorInterface $doctors)
    {
        $this->doctors = $doctors;
    }

    /**
     * @param int $candidate
     */
    public function assertions(mixed $candidate) : void
    {
        DomainAssertion::integer($candidate);
        DomainAssertion::greaterOrEqualThan($candidate, 0);
        DomainAssertion::null($this->doctors->findByExternalId($candidate), 'Doctor with this external ID already exists.');
    }
}

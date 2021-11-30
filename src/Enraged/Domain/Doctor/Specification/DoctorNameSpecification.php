<?php

declare(strict_types=1);

namespace Enraged\Domain\Doctor\Specification;

use Enraged\Domain\AbstractSpecification;
use Enraged\Domain\Assertion\DomainAssertion;

class DoctorNameSpecification extends AbstractSpecification
{
    /**
     * @param string $candidate
     */
    public function assertions(mixed $candidate) : void
    {
        DomainAssertion::string($candidate, 'Doctor is not a string!');
        DomainAssertion::notEmpty($candidate, 'Empty doctor name!');
        DomainAssertion::maxLength($candidate, 128, 'Too long doctor name!');
    }
}

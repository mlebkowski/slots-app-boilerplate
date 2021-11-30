<?php

declare(strict_types=1);

namespace Enraged\Domain;

use Enraged\Domain\Exception\DomainInvalidAssertionException;

abstract class AbstractSpecification implements SpecificationInterface
{
    private string $error = '';
    private mixed $candidate;

    public function isSatisfiedBy(mixed $candidate) : bool
    {
        try {
            $this->candidate = $candidate;
            $this->assertions($candidate);
        } catch (DomainInvalidAssertionException $exception) {
            $this->error = $exception->getMessage();

            return false;
        }

        return true;
    }

    /**
     * @throws DomainInvalidAssertionException
     */
    abstract public function assertions(mixed $candidate) : void;

    public function error() : string
    {
        return $this->error;
    }

    public function lastCandidate() : mixed
    {
        return $this->candidate;
    }
}

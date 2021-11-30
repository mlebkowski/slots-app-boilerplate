<?php

declare(strict_types=1);

namespace Enraged\Domain;

interface SpecificationInterface
{
    public function isSatisfiedBy(mixed $candidate) : bool;

    public function error() : string;

    public function lastCandidate() : mixed;
}

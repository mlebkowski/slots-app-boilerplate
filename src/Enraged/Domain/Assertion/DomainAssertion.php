<?php

declare(strict_types=1);

namespace Enraged\Domain\Assertion;

use Assert\Assertion;
use Enraged\Domain\Exception\DomainInvalidAssertionException;

class DomainAssertion extends Assertion
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected static $exceptionClass = DomainInvalidAssertionException::class;
}

<?php

declare(strict_types=1);

namespace Enraged\Domain\Assertion;

class DomainAssertion
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected static $exceptionClass = \Enraged\Domain\Exception\DomainInvalidAssertionException::class;
}

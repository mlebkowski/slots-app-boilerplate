<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Assertion;

use Assert\Assertion;
use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;

class InfrastructureAssertion extends Assertion
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected static $exceptionClass = InfrastructureInvalidAssertionException::class;
}

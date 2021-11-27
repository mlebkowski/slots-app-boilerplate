<?php

declare(strict_types=1);

namespace Enraged\Application\Assertion;

use Assert\Assertion;
use Enraged\Application\Exception\ApplicationInvalidAssertionException;

class ApplicationAssertion extends Assertion
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected static $exceptionClass = ApplicationInvalidAssertionException::class;
}

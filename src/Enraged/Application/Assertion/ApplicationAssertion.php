<?php

declare(strict_types=1);

namespace Enraged\Application\Assertion;

use Enraged\Application\Exception\ApplicationInvalidAssertionException;
use Enraged\Values\Assertion;

class ApplicationAssertion extends Assertion
{
    /**
     * Exception to throw when an assertion failed.
     *
     * @var string
     */
    protected static $exceptionClass = ApplicationInvalidAssertionException::class;
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Application\Assertion;

use Enraged\Application\Assertion\ApplicationAssertion;
use Enraged\Application\Exception\ApplicationInvalidAssertionException;
use Enraged\Tests\Unit\UnitTestCase;

class ApplicationAssertionTest extends UnitTestCase
{
    public function test_throws_correct_exception()
    {
        $this->expectException(ApplicationInvalidAssertionException::class);
        ApplicationAssertion::notEmpty([]);
    }
}

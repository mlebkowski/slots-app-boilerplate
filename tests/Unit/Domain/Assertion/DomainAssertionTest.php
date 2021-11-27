<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Assertion;

use Enraged\Domain\Assertion\DomainAssertion;
use Enraged\Domain\Exception\DomainInvalidAssertionException;
use Enraged\Tests\Unit\UnitTestCase;

class DomainAssertionTest extends UnitTestCase
{
    public function test_throws_correct_exception() : void
    {
        $this->expectException(DomainInvalidAssertionException::class);
        DomainAssertion::notEmpty([]);
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Infrastructure\Assertion;

use Enraged\Infrastructure\Assertion\InfrastructureAssertion;
use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;
use Enraged\Tests\Unit\UnitTestCase;

class InfrastructureAssertionTest extends UnitTestCase
{
    public function test_throws_correct_exception() : void
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        InfrastructureAssertion::notEmpty([]);
    }
}

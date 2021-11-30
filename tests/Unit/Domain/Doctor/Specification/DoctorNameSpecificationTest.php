<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Domain\Doctor\Specification;

use Enraged\Domain\Doctor\Specification\DoctorNameSpecification;
use Enraged\Tests\Unit\UnitTestCase;
use stdClass;

class DoctorNameSpecificationTest extends UnitTestCase
{
    public function test_rejects_non_strings()
    {
        $this->assertFalse((new DoctorNameSpecification())->isSatisfiedBy(new stdClass()));
    }

    public function test_rejects_empty_strings()
    {
        $this->assertFalse((new DoctorNameSpecification())->isSatisfiedBy(''));
    }

    public function test_rejects_too_long_strings()
    {
        $this->assertFalse((new DoctorNameSpecification())->isSatisfiedBy(str_pad('#', 128 + 1)));
    }
}

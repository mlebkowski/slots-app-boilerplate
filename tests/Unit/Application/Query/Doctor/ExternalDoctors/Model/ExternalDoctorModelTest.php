<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Application\Query\Doctor\ExternalDoctors\Model;

use Enraged\Application\Exception\ApplicationInvalidAssertionException;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorModel;
use Enraged\Tests\Unit\UnitTestCase;

class ExternalDoctorModelTest extends UnitTestCase
{
    public function test_smoke()
    {
        $this->assertInstanceOf(ExternalDoctorModel::class, new ExternalDoctorModel(0, 'Test'));
    }

    public function test_wont_accept_negative_number_as_id()
    {
        $this->expectException(ApplicationInvalidAssertionException::class);
        new ExternalDoctorModel(-1, 'Test');
    }

    public function test_wont_accept_empty_name()
    {
        $this->expectException(ApplicationInvalidAssertionException::class);
        new ExternalDoctorModel(0, '');
    }
}

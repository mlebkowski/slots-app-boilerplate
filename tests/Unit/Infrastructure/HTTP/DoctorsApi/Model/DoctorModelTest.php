<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Infrastructure\HTTP\DoctorsApi\Model;

use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use PHPUnit\Framework\TestCase;

class DoctorModelTest extends TestCase
{
    public function test_smoke()
    {
        $this->assertInstanceOf(DoctorModel::class, new DoctorModel(0, 'Test'));
    }

    public function test_wont_accept_negative_number_as_id()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        new DoctorModel(-1, 'Test');
    }

    public function test_wont_accept_empty_name()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        new DoctorModel(0, '');
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Infrastructure\HTTP\DoctorsApi\Model;

use DateInterval;
use DateTimeImmutable;
use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorTimeSlotModel;
use PHPUnit\Framework\TestCase;

class DoctorTimeSlotModelTest extends TestCase
{
    public function test_smoke()
    {
        $this->assertInstanceOf(DoctorTimeSlotModel::class, new DoctorTimeSlotModel(0, new DateTimeImmutable(), (new DateTimeImmutable())->add(new DateInterval('PT1H'))));
    }

    public function test_wont_accept_negative_number_as_doctor_id()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        new DoctorTimeSlotModel(-1, new DateTimeImmutable(), (new DateTimeImmutable())->add(new DateInterval('PT1H')));
    }

    public function test_wont_accept_time_slot_ending_before_it_was_started()
    {
        $this->expectException(InfrastructureInvalidAssertionException::class);
        new DoctorTimeSlotModel(0, new DateTimeImmutable(), (new DateTimeImmutable())->sub(new DateInterval('PT1H')));
    }
}

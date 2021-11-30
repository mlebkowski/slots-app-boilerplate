<?php

declare(strict_types=1);

namespace Enraged\Tests\Unit\Application\Query\Doctor\ExternalDoctors\Model;

use DateInterval;
use DateTimeImmutable;
use Enraged\Application\Exception\ApplicationInvalidAssertionException;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotModel;
use Enraged\Tests\Unit\UnitTestCase;

class DoctorTimeSlotModelTest extends UnitTestCase
{
    public function test_smoke()
    {
        $this->assertInstanceOf(ExternalDoctorTimeSlotModel::class, new ExternalDoctorTimeSlotModel(0, new DateTimeImmutable(), (new DateTimeImmutable())->add(new DateInterval('PT1H'))));
    }

    public function test_wont_accept_negative_number_as_doctor_id()
    {
        $this->expectException(ApplicationInvalidAssertionException::class);
        new ExternalDoctorTimeSlotModel(-1, new DateTimeImmutable(), (new DateTimeImmutable())->add(new DateInterval('PT1H')));
    }

    public function test_wont_accept_time_slot_ending_before_it_was_started()
    {
        $this->expectException(ApplicationInvalidAssertionException::class);
        new ExternalDoctorTimeSlotModel(0, new DateTimeImmutable(), (new DateTimeImmutable())->sub(new DateInterval('PT1H')));
    }
}

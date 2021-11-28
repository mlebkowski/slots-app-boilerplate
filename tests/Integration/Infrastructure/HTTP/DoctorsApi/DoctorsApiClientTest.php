<?php

declare(strict_types=1);

namespace Enraged\Tests\Integration\Infrastructure\HTTP\DoctorsApi;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Infrastructure\HTTP\Client\InMemoryHttpClientResponse;
use Enraged\Infrastructure\HTTP\DoctorsApi\DoctorsApiClient;
use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorTimeSlotsApiRequestFilter;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorModel;
use Enraged\Infrastructure\HTTP\DoctorsApi\Model\DoctorTimeSlotModel;
use Enraged\Tests\Context\Project\Infrastructure\HttpContextTrait;
use Enraged\Tests\Integration\IntegrationTestCase;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class DoctorsApiClientTest extends IntegrationTestCase
{
    use HttpContextTrait;

    public function test_listing_doctors()
    {
        $this->httpClient()->setResponse(
            new InMemoryHttpClientResponse(
                Response::HTTP_OK,
                [
                    'Content-Type' => [
                        $contentType = 'application/json',
                    ],
                ],
                ($json = json_encode(
                    $content = [
                        (object) [
                            'id' => $firstDoctorId = 0,
                            'name' => $firstDoctorName = 'John Wick',
                        ],
                        (object) [
                            'id' => $secondDoctorId = 1,
                            'name' => $secondDoctorName = 'Terminator',
                        ],
                    ]
                )) ? $json : throw new RuntimeException(),
                $content
            ),
            'GET',
            ($host = 'https://last-clinic.com') . '/api/doctors',
            [
                'auth_basic' => [
                    $username = 'grimreaper',
                    $password = 'password',
                ],
                'headers' => [
                    'Accept' => $contentType,
                ],
            ]
        );

        $subject = new DoctorsApiClient(
            $this->httpClient(),
            $host,
            $username,
            $password
        );

        /** @var DoctorModel[] $result */
        $result = iterator_to_array($subject->listDoctors(new ListDoctorsApiRequestFilter()));
        $this->assertCount(2, $result);

        $firstDoctorModel = $result[0];
        $this->assertInstanceOf(DoctorModel::class, $firstDoctorModel);
        $this->assertEquals($firstDoctorId, $firstDoctorModel->getId());
        $this->assertEquals($firstDoctorName, $firstDoctorModel->getName());

        $secondDoctorModel = $result[1];
        $this->assertInstanceOf(DoctorModel::class, $secondDoctorModel);
        $this->assertEquals($secondDoctorId, $secondDoctorModel->getId());
        $this->assertEquals($secondDoctorName, $secondDoctorModel->getName());
    }

    public function test_listing_doctor_time_slots()
    {
        $this->httpClient()->setResponse(
            new InMemoryHttpClientResponse(
                Response::HTTP_OK,
                [
                    'Content-Type' => [
                        $contentType = 'application/json',
                    ],
                ],
                ($json = json_encode(
                    $content = [
                        (object) [
                            'start' => ($firstTimeSlotStart = (new DateTimeImmutable())->sub(new DateInterval('PT8H')))
                                ->format(DateTimeInterface::ISO8601),
                            'end' => ($firstTimeSlotEnd = (new DateTimeImmutable())->sub(new DateInterval('PT7H')))
                                ->format(DateTimeInterface::ISO8601),
                        ],
                        (object) [
                            'start' => ($secondTimeSlotStart = (new DateTimeImmutable())->add(new DateInterval('PT4H')))
                                ->format(DateTimeInterface::ISO8601),
                            'end' => ($secondTimeSlotEnd = (new DateTimeImmutable())->add(new DateInterval('PT5H')))
                                ->format(DateTimeInterface::ISO8601),
                        ],
                    ]
                )) ? $json : throw new RuntimeException(),
                $content
            ),
            'GET',
            ($host = 'https://last-clinic.com') . '/api/doctors/' . ($doctorId = 0) . '/slots',
            [
                'auth_basic' => [
                    $username = 'grimreaper',
                    $password = 'password',
                ],
                'headers' => [
                    'Accept' => $contentType,
                ],
            ]
        );

        $subject = new DoctorsApiClient(
            $this->httpClient(),
            $host,
            $username,
            $password
        );

        /** @var DoctorTimeSlotModel[] $result */
        $result = iterator_to_array($subject->listDoctorTimeSlots(new ListDoctorTimeSlotsApiRequestFilter(), $doctorId));
        $this->assertCount(2, $result);

        $firstTimeSlotModel = $result[0];
        $this->assertInstanceOf(DoctorTimeSlotModel::class, $firstTimeSlotModel);
        $this->assertEquals($doctorId, $firstTimeSlotModel->getDoctorId());
        $this->assertEquals($firstTimeSlotStart->format(DateTimeInterface::ISO8601), $firstTimeSlotModel->getStart()->format(DateTimeInterface::ISO8601));
        $this->assertEquals($firstTimeSlotEnd->format(DateTimeInterface::ISO8601), $firstTimeSlotModel->getEnd()->format(DateTimeInterface::ISO8601));

        $secondTimeSlotModel = $result[1];
        $this->assertInstanceOf(DoctorTimeSlotModel::class, $secondTimeSlotModel);
        $this->assertEquals($doctorId, $secondTimeSlotModel->getDoctorId());
        $this->assertEquals($secondTimeSlotStart->format(DateTimeInterface::ISO8601), $secondTimeSlotModel->getStart()->format(DateTimeInterface::ISO8601));
        $this->assertEquals($secondTimeSlotEnd->format(DateTimeInterface::ISO8601), $secondTimeSlotModel->getEnd()->format(DateTimeInterface::ISO8601));
    }
}

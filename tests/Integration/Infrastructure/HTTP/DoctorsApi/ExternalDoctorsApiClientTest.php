<?php

declare(strict_types=1);

namespace Enraged\Tests\Integration\Infrastructure\HTTP\DoctorsApi;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorsQuery;
use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorTimeSlotsQuery;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorModel;
use Enraged\Application\Query\Doctor\ExternalDoctors\Model\ExternalDoctorTimeSlotModel;
use Enraged\Infrastructure\HTTP\Client\InMemoryHttpClientResponse;
use Enraged\Infrastructure\HTTP\DoctorsApi\ExternalDoctorsApiClient;
use Enraged\Tests\Context\Project\Infrastructure\HttpContextTrait;
use Enraged\Tests\Integration\IntegrationTestCase;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ExternalDoctorsApiClientTest extends IntegrationTestCase
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
                        [
                            'id' => $firstDoctorId = 0,
                            'name' => $firstDoctorName = 'John Wick',
                        ],
                        [
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

        $subject = new ExternalDoctorsApiClient(
            $this->httpClient(),
            $host,
            $username,
            $password
        );

        /** @var ExternalDoctorModel[] $result */
        $result = iterator_to_array($subject->listDoctors(new ListExternalDoctorsQuery()));
        $this->assertCount(2, $result);

        $firstDoctorModel = $result[0];
        $this->assertInstanceOf(ExternalDoctorModel::class, $firstDoctorModel);
        $this->assertEquals($firstDoctorId, $firstDoctorModel->getExternalId());
        $this->assertEquals($firstDoctorName, $firstDoctorModel->getName());

        $secondDoctorModel = $result[1];
        $this->assertInstanceOf(ExternalDoctorModel::class, $secondDoctorModel);
        $this->assertEquals($secondDoctorId, $secondDoctorModel->getExternalId());
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
                        [
                            'start' => ($firstTimeSlotStart = (new DateTimeImmutable())->sub(new DateInterval('PT8H')))
                                ->format(DateTimeInterface::ISO8601),
                            'end' => ($firstTimeSlotEnd = (new DateTimeImmutable())->sub(new DateInterval('PT7H')))
                                ->format(DateTimeInterface::ISO8601),
                        ],
                        [
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

        $subject = new ExternalDoctorsApiClient(
            $this->httpClient(),
            $host,
            $username,
            $password
        );

        /** @var ExternalDoctorTimeSlotModel[] $result */
        $result = iterator_to_array($subject->listDoctorTimeSlots(new ListExternalDoctorTimeSlotsQuery($doctorId)));
        $this->assertCount(2, $result);

        $firstTimeSlotModel = $result[0];
        $this->assertInstanceOf(ExternalDoctorTimeSlotModel::class, $firstTimeSlotModel);
        $this->assertEquals($doctorId, $firstTimeSlotModel->getExternalDoctorId());
        $this->assertEquals($firstTimeSlotStart->format(DateTimeInterface::ISO8601), $firstTimeSlotModel->getStart()->format(DateTimeInterface::ISO8601));
        $this->assertEquals($firstTimeSlotEnd->format(DateTimeInterface::ISO8601), $firstTimeSlotModel->getEnd()->format(DateTimeInterface::ISO8601));

        $secondTimeSlotModel = $result[1];
        $this->assertInstanceOf(ExternalDoctorTimeSlotModel::class, $secondTimeSlotModel);
        $this->assertEquals($doctorId, $secondTimeSlotModel->getExternalDoctorId());
        $this->assertEquals($secondTimeSlotStart->format(DateTimeInterface::ISO8601), $secondTimeSlotModel->getStart()->format(DateTimeInterface::ISO8601));
        $this->assertEquals($secondTimeSlotEnd->format(DateTimeInterface::ISO8601), $secondTimeSlotModel->getEnd()->format(DateTimeInterface::ISO8601));
    }
}

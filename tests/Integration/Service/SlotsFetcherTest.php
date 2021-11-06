<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Entity\Slot;
use App\Repository\SlotPersister;
use App\Repository\SlotRepository;
use App\Service\DoctorFetchingClient;
use App\Service\SlotFetchingClient;
use App\Service\SlotsFetcher;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlotsFetcherTest extends KernelTestCase
{
    private const API_BASE_URL = 'https://www.someapi.com/';

    private ObjectProphecy|LoggerInterface $logger;
    private null|SlotRepository $slotsRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->slotsRepository = $this->getContainer()->get(SlotRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM '.Slot::class)->execute();
    }

    public function testSuccessfulFetching(): void
    {
        //arrange
        $slotsFetcher = new SlotsFetcher(
            $this->logger->reveal(),
            new DoctorFetchingClient($this->createDoctorApiClient()),
            new SlotFetchingClient($this->createSlotFetchingClientWithValidResponses()),
            $this->getContainer()->get(SlotPersister::class)
        );

        //act
        $slotsFetcher->fetch();

        //assert
        self::assertEquals(3, count($this->slotsRepository->findAll()));
        // TODO: maybe more tests to check if content of persisted slots is definitely correct
        self::assertEquals(new \DateTime('2020-02-01T14:50:00+00:00'), $this->getDateFromOfSlotByDoctorById(1));
        self::assertEquals(new \DateTime('2020-03-01T14:50:00+00:00'), $this->getDateFromOfSlotByDoctorById(2));
        self::assertEquals(new \DateTime('2020-04-01T14:50:00+00:00'), $this->getDateFromOfSlotByDoctorById(3));
    }

    public function testLogsAndContinueWhenFailureOnSlotsApi(): void
    {
        //arrange
        $slotsFetcher = new SlotsFetcher(
            $this->logger->reveal(),
            new DoctorFetchingClient($this->createDoctorApiClient()),
            new SlotFetchingClient($this->createSlotFetchingClientWithResponse500ForDoctor2()),
            $this->getContainer()->get(SlotPersister::class)
        );

        //act
        $slotsFetcher->fetch();

        //assert
        self::assertEquals(2, count($this->slotsRepository->findAll()));
        self::assertEquals(0, count($this->slotsRepository->findBy(['doctorId' => 2])));
        $this->logger->error(Argument::cetera())->shouldHaveBeenCalled();
    }

    public function testStopsWhenDoctorsFetchingFails(): void
    {
        //TODO: implement along with doctors api error handling
    }

    private function getDateFromOfSlotByDoctorById(int $id): \DateTimeInterface
    {
        return $this->slotsRepository->findOneBy(['doctorId' => $id])->getDateFrom();
    }

    private function createDoctorApiClient(): HttpClientInterface
    {
        return new MockHttpClient(
            [
                new MockResponse(
                    json_encode(
                        [
                            [
                                'id' => 1,
                                'name'=> 'First Doctor',
                            ],
                            [
                                'id' => 2,
                                'name'=> 'Second Doctor',
                            ],
                            [
                                'id' => 3,
                                'name'=> 'Third Doctor',
                            ],
                        ]
                    )
                )
            ],
        self::API_BASE_URL
        );
    }

    private function createSlotFetchingClientWithValidResponses(): HttpClientInterface
    {
        return new MockHttpClient(
            [
                new MockResponse(
                    json_encode(
                        [
                            [
                                "start" => "2020-02-01T14:50:00+00:00",
                                "end" => "2020-02-01T15:30:00+00:00"
                            ],
                        ]
                    )
                ),
                new MockResponse(
                    json_encode(
                        [
                            [
                                "start" => "2020-03-01T14:50:00+00:00",
                                "end" => "2020-03-01T15:30:00+00:00"
                            ],
                        ]
                    )
                ),
                new MockResponse(
                    json_encode(
                        [
                            [
                                "start" => "2020-04-01T14:50:00+00:00",
                                "end" => "2020-04-01T15:30:00+00:00"
                            ],
                        ]
                    )
                )
            ],
            self::API_BASE_URL
        );
    }

    private function createSlotFetchingClientWithResponse500ForDoctor2(): HttpClientInterface
    {
        return new MockHttpClient(
            [
                new MockResponse(
                    json_encode(
                        [
                            [
                                "start" => "2020-02-01T14:50:00+00:00",
                                "end" => "2020-02-01T15:30:00+00:00"
                            ],
                        ]
                    )
                ),
                new MockResponse(
                    json_encode([]),
                    [
                        'http_code' => 500
                    ]
                ),
                new MockResponse(
                    json_encode(
                        [
                            [
                                "start" => "2020-04-01T14:50:00+00:00",
                                "end" => "2020-04-01T15:30:00+00:00"
                            ],
                        ]
                    )
                )
            ],
            self::API_BASE_URL
        );
    }
}

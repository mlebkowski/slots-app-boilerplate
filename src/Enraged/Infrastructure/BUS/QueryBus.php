<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\BUS;

use Enraged\Infrastructure\Exception\InfrastructureBusException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;

class QueryBus
{
    protected MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @param StampInterface[] $stamps
     *
     * @throws InfrastructureBusException
     */
    public function query(object $message, array $stamps = []) : object
    {
        return ($stamp = $this->queryBus->dispatch($message, $stamps)->last(HandledStamp::class)) instanceof HandledStamp
            ? $stamp->getResult()
            : throw new InfrastructureBusException('Query did not returned valid result!');
    }
}

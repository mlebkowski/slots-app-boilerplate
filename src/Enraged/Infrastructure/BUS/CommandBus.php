<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\BUS;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

class CommandBus
{
    protected MessageBusInterface $command_bus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->command_bus = $commandBus;
    }

    /**
     * @param StampInterface[] $stamps
     */
    public function command(object $message, array $stamps = []) : Envelope
    {
        return $this->command_bus->dispatch($message, $stamps);
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project\Infrastructure;

use Enraged\Infrastructure\BUS\CommandBus;
use Enraged\Infrastructure\BUS\EventBus;
use Enraged\Infrastructure\BUS\QueryBus;
use InvalidArgumentException;

trait BusContextTrait
{
    public function commandBus() : CommandBus
    {
        return ($bus = $this->getContainer()->get(CommandBus::class)) instanceof CommandBus
            ? $bus
            : throw new InvalidArgumentException('Not a CommandBus instance.');
    }

    public function queryBus() : QueryBus
    {
        return ($bus = $this->getContainer()->get(QueryBus::class)) instanceof QueryBus
            ? $bus
            : throw new InvalidArgumentException('Not a CommandBus instance.');
    }

    public function eventBus() : EventBus
    {
        return ($bus = $this->getContainer()->get(EventBus::class)) instanceof EventBus
            ? $bus
            : throw new InvalidArgumentException('Not a CommandBus instance.');
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Tests\Context\Project\Infrastructure;

use InvalidArgumentException;
use Symfony\Component\Messenger\MessageBusInterface;

trait BusContextTrait
{
    public function commandBus() : MessageBusInterface
    {
        if (($bus = $this->getContainer()->get('command.bus')) instanceof MessageBusInterface) {
            return $bus;
        }
        throw new InvalidArgumentException('Bus instance is not implementing expected interface');
    }

    public function queryBus() : MessageBusInterface
    {
        if (($bus = $this->getContainer()->get('query.bus')) instanceof MessageBusInterface) {
            return $bus;
        }
        throw new InvalidArgumentException('Bus instance is not implementing expected interface');
    }

    public function eventBus() : MessageBusInterface
    {
        if (($bus = $this->getContainer()->get('event.bus')) instanceof MessageBusInterface) {
            return $bus;
        }
        throw new InvalidArgumentException('Bus instance is not implementing expected interface');
    }
}

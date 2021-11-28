<?php

declare(strict_types=1);

namespace Enraged\Tests\Integration\Application\CommandHandler;

use Enraged\Application\Command\LogMessageCommand;
use Enraged\Tests\Context\Project\Infrastructure\BusContextTrait;
use Enraged\Tests\Integration\IntegrationTestCase;

class LogMessageHandlerTest extends IntegrationTestCase
{
    use BusContextTrait;

    public function test_dispatching_message()
    {
        $this->commandBus()->dispatch(new LogMessageCommand($message = 'test'));
        $this->expectOutputString(sprintf('\'%s\'', $message));
    }
}

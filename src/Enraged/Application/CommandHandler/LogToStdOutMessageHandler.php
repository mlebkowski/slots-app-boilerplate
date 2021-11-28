<?php

declare(strict_types=1);

namespace Enraged\Application\CommandHandler;

use Enraged\Application\Command\LogToStdOutMessageCommand;

class LogToStdOutMessageHandler
{
    public function __invoke(LogToStdOutMessageCommand $command) : void
    {
        var_export($command->getMessage());
    }
}

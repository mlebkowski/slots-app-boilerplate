<?php

declare(strict_types=1);

namespace Enraged\Application\CommandHandler;

use Enraged\Application\Command\LogMessageCommand;

class LogMessageHandler
{
    public function __invoke(LogMessageCommand $command) : void
    {
        var_export($command->getMessage());
    }
}

<?php

declare(strict_types=1);

namespace Enraged\Application\Command;

class LogMessageCommand
{
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage() : string
    {
        return $this->message;
    }
}

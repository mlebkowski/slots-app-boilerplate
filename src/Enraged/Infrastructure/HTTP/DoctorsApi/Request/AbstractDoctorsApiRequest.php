<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

abstract class AbstractDoctorsApiRequest
{
    protected string $host;
    protected string $username;
    protected string $password;

    public function __construct(string $host, string $username, string $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function host() : string
    {
        return $this->host;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function password() : string
    {
        return $this->password;
    }
}

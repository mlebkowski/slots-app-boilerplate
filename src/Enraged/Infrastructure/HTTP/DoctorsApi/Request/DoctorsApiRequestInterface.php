<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

interface DoctorsApiRequestInterface
{
    public function method() : string;

    public function path() : string;

    public function host() : string;

    public function username() : string;

    public function password() : string;

    public function accept() : string;

    public function expectCode() : int;
}

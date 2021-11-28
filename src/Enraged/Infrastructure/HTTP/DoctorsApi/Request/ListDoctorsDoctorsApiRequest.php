<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

use Enraged\Infrastructure\HTTP\DoctorsApi\Filter\ListDoctorsApiRequestFilter;
use Symfony\Component\HttpFoundation\Response;

class ListDoctorsDoctorsApiRequest extends AbstractDoctorsApiRequest implements DoctorsApiRequestInterface
{
    protected ListDoctorsApiRequestFilter $filter;

    public function __construct(ListDoctorsApiRequestFilter $filter, string $host, string $username, string $password)
    {
        parent::__construct($host, $username, $password);
        $this->filter = $filter;
    }

    public function method() : string
    {
        return 'GET';
    }

    public function path() : string
    {
        return 'api/doctors';
    }

    public function accept() : string
    {
        return 'application/json';
    }

    public function expectCode() : int
    {
        return Response::HTTP_OK;
    }
}

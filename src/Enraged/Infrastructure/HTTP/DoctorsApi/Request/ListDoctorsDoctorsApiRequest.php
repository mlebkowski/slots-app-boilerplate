<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Request;

use Enraged\Application\Query\Doctor\ExternalDoctors\ListExternalDoctorsQuery;
use Symfony\Component\HttpFoundation\Response;

class ListDoctorsDoctorsApiRequest extends AbstractDoctorsApiRequest implements DoctorsApiRequestInterface
{
    protected ListExternalDoctorsQuery $query;

    public function __construct(ListExternalDoctorsQuery $query, string $host, string $username, string $password)
    {
        parent::__construct($host, $username, $password);
        $this->query = $query;
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

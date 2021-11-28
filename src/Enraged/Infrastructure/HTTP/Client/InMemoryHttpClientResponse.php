<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\Client;

use Enraged\Infrastructure\Exception\InfrastructureNotImplementedException;
use Symfony\Contracts\HttpClient\ResponseInterface;

class InMemoryHttpClientResponse implements ResponseInterface
{
    protected int $statusCode;
    protected array $headers;
    protected string $content;
    protected array $contentAsArray;

    public function __construct(int $statusCode, array $headers, string $content, array $contentAsArray)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->content = $content;
        $this->contentAsArray = $contentAsArray;
    }

    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function getHeaders(bool $throw = true) : array
    {
        return $this->headers;
    }

    public function getContent(bool $throw = true) : string
    {
        return $this->content;
    }

    public function toArray(bool $throw = true) : array
    {
        return $this->contentAsArray;
    }

    /**
     * @throws InfrastructureNotImplementedException
     */
    public function cancel() : void
    {
        throw new InfrastructureNotImplementedException();
    }

    /**
     * @throws InfrastructureNotImplementedException
     */
    public function getInfo(string $type = null)
    {
        throw new InfrastructureNotImplementedException();
    }
}

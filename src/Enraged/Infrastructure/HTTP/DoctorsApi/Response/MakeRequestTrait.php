<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\HTTP\DoctorsApi\Response;

use Enraged\Infrastructure\Assertion\InfrastructureAssertion;
use Enraged\Infrastructure\Exception\InfrastructureHttpBadRequestException;
use Enraged\Infrastructure\Exception\InfrastructureHttpBadResponseException;
use Enraged\Infrastructure\Exception\InfrastructureHttpException;
use Enraged\Infrastructure\Exception\InfrastructureInvalidAssertionException;
use Enraged\Infrastructure\HTTP\DoctorsApi\Request\DoctorsApiRequestInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait MakeRequestTrait
{
    /**
     * @throws InfrastructureHttpException
     */
    private function makeRequest(DoctorsApiRequestInterface $request) : ResponseInterface
    {
        try {
            $response = $this->http_client->request(
                $request->method(),
                $request->host() . '/' . $request->path(),
                [
                    'auth_basic' => [
                        $request->username(),
                        $request->password(),
                    ],
                    'headers' => [
                        'Accept' => $request->accept(),
                    ],
                ]
            );
            InfrastructureAssertion::eq($request->expectCode(), $response->getStatusCode());
            InfrastructureAssertion::keyIsset($response->getHeaders(false), 'Content-Type');
            InfrastructureAssertion::eq($request->accept(), $response->getHeaders(false)['Content-Type'][0]);

            return $response;
        } catch (ClientExceptionInterface $exception) {
            throw new InfrastructureHttpBadRequestException($exception->getMessage(), intval($exception->getCode()), $exception);
        } catch (InfrastructureInvalidAssertionException|TransportExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            throw new InfrastructureHttpBadResponseException($exception->getMessage(), intval($exception->getCode()), $exception);
        }
    }
}

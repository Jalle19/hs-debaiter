<?php

namespace Jalle19\HsDebaiter\Http;

use JMS\Serializer\Serializer;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandler implements MiddlewareInterface
{
    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($e);
        }
    }

    public function createErrorResponse(\Throwable $e): ResponseInterface
    {
        $response = (new Response())
            ->withStatus($this->determineStatusCode($e))
            ->withHeader('Content-Type', 'application/json');

        $body = [
            'code' => $response->getStatusCode(),
            'message' => $e->getMessage(),
        ];

        $response->getBody()->write($this->serializer->serialize($body, 'json'));

        return $response;
    }

    private function determineStatusCode(\Throwable $e): int
    {
        switch (get_class($e)) {
            case BadRequestException::class:
                return 400;
            case NotFoundException::class:
                return 404;
            default:
                return 500;
        }
    }
}

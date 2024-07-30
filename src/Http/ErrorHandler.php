<?php

namespace Jalle19\HsDebaiter\Http;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorHandler
{

    public static function handleException(ServerRequestInterface $request, \Exception $e): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('Exception thrown: '. $e->getMessage());

        return $response;
    }
}
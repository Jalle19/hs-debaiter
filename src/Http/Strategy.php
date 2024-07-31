<?php

namespace Jalle19\HsDebaiter\Http;

use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Server\MiddlewareInterface;

class Strategy extends ApplicationStrategy
{
    public function getThrowableHandler(): MiddlewareInterface
    {
        return $this->getContainer()->get(ErrorHandler::class);
    }
}

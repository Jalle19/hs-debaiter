<?php

namespace Jalle19\HsDebaiter;

use Jalle19\HsDebaiter\HsApi\HsApiService;
use Jalle19\HsDebaiter\Http\ArticleController;
use Jalle19\HsDebaiter\Http\CategoryController;
use Jalle19\HsDebaiter\Http\ErrorHandler;
use Jalle19\HsDebaiter\Http\Strategy;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use Jalle19\HsDebaiter\Repository\CategoryRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use League\Container\Container;
use League\Route\Router;
use PhpNexus\Cors\CorsService;
use PhpNexus\CorsPsr7\MiddlewarePsr15;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\Psr18Client;

class Application
{

    public function getContainer(): ContainerInterface
    {
        $container = new Container();

        // Add shared instances
        $container->addShared(\PDO::class, $this->getPdo());
        $container->addShared(
            Serializer::class,
            SerializerBuilder::create()
                ->setSerializationContextFactory(function () {
                    // Include null properties
                    return SerializationContext::create()
                        ->setSerializeNull(true);
                })
                ->build()
        );

        // Add concrete implementations
        $container->add(ClientInterface::class, new Psr18Client());

        // Wire everything
        $container->add(ArticleController::class)
            ->addArgument(ArticleRepository::class)
            ->addArgument(Serializer::class);
        $container->add(CategoryController::class)
            ->addArgument(CategoryRepository::class)
            ->addArgument(Serializer::class);
        $container->add(ArticleRepository::class)
            ->addArgument(\PDO::class);
        $container->add(CategoryRepository::class)
            ->addArgument(\PDO::class);
        $container->add(ErrorHandler::class)
            ->addArgument(Serializer::class);
        $container->add(HsApiService::class)
            ->addArgument(ClientInterface::class);

        return $container;
    }

    public function getRouter(ContainerInterface $container): Router
    {
        $corsMiddleware = new MiddlewarePsr15(new CorsService([
            'allowOrigins' => ['*'],
        ]));

        $strategy = new Strategy();
        $strategy->setContainer($container);
        $router = new Router();
        $router->setStrategy($strategy);
        $router->middleware($corsMiddleware);

        return $router;
    }

    private function getPdo(): \PDO
    {
        $pdo = new \PDO(
            sprintf('mysql:host=%s;port=%d;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']),
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
        );
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}

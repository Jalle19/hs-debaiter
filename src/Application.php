<?php

namespace Jalle19\HsDebaiter;

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
use Middlewares\Cors;
use Neomerx\Cors\Analyzer;
use Neomerx\Cors\Strategies\Settings;
use Psr\Container\ContainerInterface;

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

        return $container;
    }

    public function getRouter(ContainerInterface $container): Router
    {
        $analyzerSettings = (new Settings())
            ->init('http', 'localhost', 8080)
            ->enableAllOriginsAllowed();
        $analyzer = Analyzer::instance($analyzerSettings);
        $corsMiddleware = new Cors($analyzer);

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

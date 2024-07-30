<?php

use Dotenv\Dotenv;
use Jalle19\HsDebaiter\Http\ArticleController;
use Jalle19\HsDebaiter\Http\ErrorHandler;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$pdo = new \PDO(
    sprintf('mysql:host=%s;port=%d;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']),
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$container = new Container();
$container->add(ArticleController::class)
    ->addArgument(ArticleRepository::class)
    ->addArgument(Serializer::class);
$container->add(ArticleRepository::class)
    ->addArgument(\PDO::class);
$container->addShared(\PDO::class, $pdo);
$container->addShared(Serializer::class, SerializerBuilder::create()->build());

$factory = new Psr17Factory();
$creator = new ServerRequestCreator($factory, $factory, $factory, $factory);

$request = $creator->fromGlobals();

$strategy = new ApplicationStrategy();
$strategy->setContainer($container);
$router = new Router();
$router->setStrategy($strategy);

$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Response();
    $response->getBody()->write('hs-debaiter');

    return $response;
});

$router->map('GET', '/articles', [ArticleController::class, 'getArticles']);
$router->map('GET', '/article/{guid}', [ArticleController::class, 'getArticle']);

try {
    $response = $router->dispatch($request);
} catch (Exception $e) {
    $response = ErrorHandler::handleException($request, $e);
}

(new SapiEmitter())->emit($response);
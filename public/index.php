<?php

use Dotenv\Dotenv;
use Jalle19\HsDebaiter\Application;
use Jalle19\HsDebaiter\Http\ArticleController;
use Jalle19\HsDebaiter\Http\ErrorHandler;
use Jalle19\HsDebaiter\Http\Strategy;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\Container;
use League\Route\Router;
use Middlewares\Cors;
use Neomerx\Cors\Analyzer;
use Neomerx\Cors\Strategies\Settings;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Initialize the container and router
$app = new Application();
$container = $app->getContainer();
$router = $app->getRouter($container);

// Configure routes
$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Response();
    $response->getBody()->write('hs-debaiter');

    return $response;
});

$router->map('GET', '/articles/todays-changed', [ArticleController::class, 'getTodaysChangedArticles']);
$router->map('GET', '/articles/frequently-changed', [ArticleController::class, 'getFrequentlyChangedArticles']);
$router->map('GET', '/article/{guid}', [ArticleController::class, 'getArticle']);

// Pass the request through the router and emit response
$factory = new Psr17Factory();
$creator = new ServerRequestCreator($factory, $factory, $factory, $factory);
$request = $creator->fromGlobals();
$response = $router->dispatch($request);

(new SapiEmitter())->emit($response);

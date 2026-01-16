<?php

// TODO: Remove once dependencies with deprecation errors are updated
error_reporting(E_ALL ^ E_DEPRECATED);

use Forensic\FeedParser\Parser;
use Jalle19\HsDebaiter\Application;
use Jalle19\HsDebaiter\Console\ImportRssFeedCommand;
use Jalle19\HsDebaiter\Console\UpdateHeadlineTestTitlesCommand;
use Jalle19\HsDebaiter\HsApi\HsApiService;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use Monolog\Logger;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;

require __DIR__ . '/../vendor/autoload.php';

// Initialize container
$app = new Application();
$container = $app->getContainer();

// Create a console application
$consoleApp = new SymfonyConsoleApplication();

// Create dependencies
$logger = new Logger('hs-debaiter');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Logger::INFO));
$feedParser = new Parser();
$articleRepository = $container->get(ArticleRepository::class);
$httpClient = $container->get(ClientInterface::class);
$hsApiService = $container->get(HsApiService::class);

// Register commands
$consoleApp->add(new ImportRssFeedCommand($logger, $feedParser, $hsApiService, $articleRepository));
$consoleApp->add(new UpdateHeadlineTestTitlesCommand($logger, $hsApiService, $articleRepository));

// Run it
$consoleApp->run();

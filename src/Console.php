<?php

// TODO: Remove once dependencies with deprecation errors are updated
error_reporting(E_ALL ^ E_DEPRECATED);

use Dotenv\Dotenv;
use Forensic\FeedParser\Parser;
use Jalle19\HsDebaiter\Application;
use Jalle19\HsDebaiter\Console\ImportRssFeedCommand;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use Monolog\Logger;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Initiailize container
$app = new Application();
$container = $app->getContainer();

// Create a console application
$consoleApp = new SymfonyConsoleApplication();

// Add command for importing the RSS feed
$logger = new Logger('hs-debaiter');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Logger::INFO));
$feedParser = new Parser();
$articleRepository = $container->get(ArticleRepository::class);
$consoleApp->add(new ImportRssFeedCommand($logger, $feedParser, $articleRepository));

// Run it
$consoleApp->run();

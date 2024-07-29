<?php

use Dotenv\Dotenv;
use Forensic\FeedParser\Parser;
use Jalle19\HsDebaiter\ArticleRepository;
use Jalle19\HsDebaiter\Console\ImportRssFeedCommand;
use Monolog\Logger;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$application = new Application();

$logger = new Logger('hs-debaiter');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Logger::INFO));
$feedParser = new Parser();
$pdo = new \PDO(
    sprintf('mysql:host=%s;port=%d;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']),
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$articleRepository = new ArticleRepository($pdo);
$application->add(new ImportRssFeedCommand($logger, $feedParser, $articleRepository));

$application->run();

<?php

namespace Jalle19\HsDebaiter\Console;

use Jalle19\HsDebaiter\HsApi\HsApiService;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function Jalle19\HsDebaiter\HsApi\isLiveArticle;

class UpdateHeadlineTestTitlesCommand extends Command
{
    protected static $defaultName = 'update-headline-test-titles';

    private LoggerInterface $logger;
    private HsApiService $hsApiService;
    private ArticleRepository $articleRepository;

    /**
     * @param LoggerInterface $logger
     * @param HsApiService $hsApiService
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        LoggerInterface $logger,
        HsApiService $hsApiService,
        ArticleRepository $articleRepository
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->hsApiService = $hsApiService;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Fetch all recent articles
        $articles = $this->articleRepository->getRecentlyAddedArticles();

        foreach ($articles as $article) {
            $this->logger->info('Processing article', ['article' => $article->getGuid()]);
            $items = $this->hsApiService->getLaneItems($article);

            // Ignore live articles, their headlines can naturally change without it being bait
            if (isLiveArticle($items)) {
                $this->logger->info('Article is live, ignoring', ['article' => $article->getGuid()]);
                continue;
            }

            // Not all articles have bait tests
            if (!isset($items['headlineTestTitle']) || !isset($items['headlineVariantID'])) {
                $this->logger->info('Article has no headline test titles', ['article' => $article->getGuid()]);
                continue;
            }

            $testTitle = $items['headlineTestTitle'];
            $variantId = $items['headlineVariantID'];

            // Store the headline variant if we don't have it
            if (!$this->articleRepository->hasHeadlineVariant($article, $variantId)) {
                $this->logger->info('Storing variant test title for article', [
                    'article' => $article->getGuid(),
                    'variant' => $variantId,
                    'testTitle' => $testTitle,
                ]);

                $this->articleRepository->storeHeadlineVariant($article, $variantId, $testTitle);
            }
        }

        return Command::SUCCESS;
    }
}

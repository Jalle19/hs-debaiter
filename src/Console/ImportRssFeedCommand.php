<?php

namespace Jalle19\HsDebaiter\Console;

use Forensic\FeedParser\Exceptions\InvalidURLException;
use Forensic\FeedParser\Exceptions\ResourceNotFoundException;
use Forensic\FeedParser\Parser;
use Jalle19\HsDebaiter\Model\Article;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportRssFeedCommand extends Command
{
    private const HS_UUSIMMAT_FEED_URL = 'https://www.hs.fi/rss/tuoreimmat.xml';

    protected static $defaultName = 'import-rss-feed';

    private LoggerInterface $logger;
    private Parser $feedParser;
    private ArticleRepository $articleRepository;

    public function __construct(
        LoggerInterface $logger,
        Parser $feedParser,
        ArticleRepository $articleRepository
    ) {
        parent::__construct();

        $this->logger = $logger;
        $this->feedParser = $feedParser;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws ResourceNotFoundException
     * @throws InvalidURLException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info('Parsing feed', ['url' => self::HS_UUSIMMAT_FEED_URL]);
        $feed = $this->feedParser->parseFromURL(self::HS_UUSIMMAT_FEED_URL)->toArray();
        $this->logger->info(
            'Got feed',
            ['name' => $feed['title'], 'lastUpdated' => $feed['lastUpdated'], 'numItems' => count($feed['items'])]
        );

        foreach ($feed['items'] as $item) {
            $article = Article::fromFeedItem($item);
            $existingArticle = $this->articleRepository->getArticle($article->getGuid());

            if (!$existingArticle) {
                $this->logger->info('Inserting new item', ['id' => $item['id'], 'title' => $item['title']]);
                $this->articleRepository->storeArticle($article);
            } else {
                if ($article->getTitle() !== $existingArticle->getTitle()) {
                    $this->logger->info(
                        'Storing title change',
                        ['old' => $existingArticle->getTitle(), 'new' => $item['title']]
                    );

                    $this->articleRepository->storeArticleTitleChange($existingArticle, $item['title']);
                } else {
                    $this->logger->debug('Nothing to do for article', ['id' => $article->getGuid()]);
                }
            }
        }
        return Command::SUCCESS;
    }
}

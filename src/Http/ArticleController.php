<?php

namespace Jalle19\HsDebaiter\Http;

use Jalle19\HsDebaiter\Repository\ArticleRepository;
use JMS\Serializer\Serializer;
use League\Route\Http\Exception\NotFoundException;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleController
{

    private ArticleRepository $articleRepository;
    private Serializer $serializer;

    /**
     * @param ArticleRepository $articleRepository
     * @param Serializer $serializer
     */
    public function __construct(ArticleRepository $articleRepository, \JMS\Serializer\Serializer $serializer)
    {
        $this->articleRepository = $articleRepository;
        $this->serializer = $serializer;
    }

    public function getArticles(ServerRequestInterface $request): ResponseInterface
    {
        $articles = $this->articleRepository->getArticles(20);

        $response = (new Response())
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($this->serializer->serialize($articles, 'json'));

        return $response;
    }

    public function getFrequentlyChangedArticles(ServerRequestInterface $request): ResponseInterface
    {
        $articles = $this->articleRepository->getFrequentlyChangedArticles(10);

        $response = (new Response())
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($this->serializer->serialize($articles, 'json'));

        return $response;
    }

    /**
     * @throws NotFoundException
     */
    public function getArticle(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $article = $this->articleRepository->getArticle($args['guid']);

        if (!$article) {
            throw new NotFoundException();
        }

        $articleTitles = $this->articleRepository->getArticleTitles($article->getId());
        $article->setArticleTitles(iterator_to_array($articleTitles));

        $response = (new Response())
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($this->serializer->serialize($article, 'json'));

        return $response;
    }
}
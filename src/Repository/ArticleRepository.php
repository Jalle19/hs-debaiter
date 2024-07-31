<?php

declare(strict_types=1);

namespace Jalle19\HsDebaiter\Repository;

use Jalle19\HsDebaiter\Model\Article;
use Jalle19\HsDebaiter\Model\ArticleTitle;

class ArticleRepository
{
    private \PDO $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getArticles(int $limit): \Generator
    {
        $stmt = $this->pdo->prepare(
            'SELECT articles.*, COUNT(article_titles.id) AS num_titles
             FROM articles
             LEFT OUTER JOIN article_titles ON (article_titles.article_id = articles.id)
             GROUP BY articles.id
             ORDER BY id DESC LIMIT :limit'
        );

        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield Article::fromDatabaseRow($row);
        }
    }

    public function getFrequentlyChangedArticles(int $limit): \Generator {
        $stmt = $this->pdo->prepare(
            'SELECT articles.*, COUNT(article_titles.id) AS num_titles
             FROM articles
             LEFT OUTER JOIN article_titles ON (article_titles.article_id = articles.id)
             GROUP BY articles.id
             ORDER BY COUNT(article_titles.id) DESC LIMIT :limit'
        );

        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield Article::fromDatabaseRow($row);
        }
    }

    public function getArticle(string $guid): ?Article
    {
        $stmt = $this->pdo->prepare(
            'SELECT articles.*, COUNT(article_titles.id) AS num_titles
             FROM articles
             LEFT OUTER JOIN article_titles ON (article_titles.article_id = articles.id)
             WHERE guid = :guid
             GROUP BY articles.id'
        );

        $stmt->execute([
            ':guid' => $guid,
        ]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return Article::fromDatabaseRow($row);
    }

    public function storeArticle(Article $article): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO articles (guid, title, url, image_url) 
             VALUES (:guid, :title, :url, :imageUrl)'
        );

        $stmt->execute([
            ':guid' => $article->getGuid(),
            ':title' => $article->getTitle(),
            ':url' => $article->getUrl(),
            ':imageUrl' => $article->getImageUrl(),
        ]);

        $id = $this->pdo->lastInsertId();
        $article->setId($id);

        $this->storeArticleTitleChange($article, $article->getTitle());
    }

    public function storeArticleTitleChange(Article $article, string $title): void
    {
        // Store the change
        $stmt = $this->pdo->prepare(
            'INSERT INTO article_titles (article_id, title)
             VALUES (:article_id, :title)'
        );

        $stmt->execute([
            ':article_id' => $article->getId(),
            ':title' => $title,
        ]);

        // Update the article itself to have the newest title
        $stmt = $this->pdo->prepare(
            'UPDATE articles SET title = :title WHERE id = :id'
        );

        $stmt->execute([
            ':title' => $title,
            ':id' => $article->getId(),
        ]);
    }

    public function getArticleTitles(int $id): \Generator
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM article_titles 
             WHERE article_id = :article_id
             ORDER BY id DESC'
        );

        $stmt->execute([':article_id' => $id]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield ArticleTitle::fromDatabaseRow($row);
        }
    }
}

<?php

declare(strict_types=1);

namespace Jalle19\HsDebaiter;

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

    public function getArticle(string $guid): ?Article
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM articles WHERE guid = :guid'
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
            'UPDATE articles SET title = :title, updated_at = CURRENT_TIMESTAMP()
             WHERE id = :id'
        );

        $stmt->execute([
            ':title' => $title,
            ':id' => $article->getId(),
        ]);
    }
}

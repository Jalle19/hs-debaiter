<?php

namespace Jalle19\HsDebaiter\Model;

class Article
{

    private ?string $id = null;
    private string $guid;
    private string $title;
    private string $url;
    private ?string $imageUrl = null;
    private \DateTimeInterface $createdAt;
    private int $numTitles = 0;
    private array $articleTitles = [];

    public static function fromFeedItem(array $item): Article
    {
        $article = new Article();
        $article->guid = $item['id'];
        $article->title = $item['title'];
        $article->url = $item['link'];

        if (isset($item['enclosure']['url'])) {
            $article->imageUrl = $item['enclosure']['url'];
        }

        return $article;
    }

    public static function fromDatabaseRow($row): Article
    {
        $article = new Article();
        $article->id = $row['id'];
        $article->guid = $row['guid'];
        $article->title = $row['title'];
        $article->url = $row['url'];
        $article->imageUrl = $row['image_url'];
        $article->createdAt = new \DateTimeImmutable($row['created_at']);

        if (isset($row['num_titles'])) {
            $article->numTitles = $row['num_titles'];
        }

        return $article;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setArticleTitles(array $articleTitles): void
    {
        $this->articleTitles = $articleTitles;
    }
}

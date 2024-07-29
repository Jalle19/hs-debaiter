<?php

namespace Jalle19\HsDebaiter;

class Article
{

    private ?string $id = null;
    private string $guid;
    private string $title;
    private string $url;
    private ?string $imageUrl = null;

    public static function fromFeedItem(array $item): Article
    {
        $article = new Article();
        $article->guid = $item['id'];
        $article->title = $item['title'];
        $article->url = $item['link'];

        if ($item['enclosure']['url']) {
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
}

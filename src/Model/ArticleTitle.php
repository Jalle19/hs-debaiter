<?php

namespace Jalle19\HsDebaiter\Model;

class ArticleTitle
{

    private string $title;
    private \DateTimeInterface $createdAt;

    public static function fromDatabaseRow(array $row): ArticleTitle
    {
        $articleTitle = new ArticleTitle();
        $articleTitle->title = $row['title'];
        $articleTitle->createdAt = new \DateTimeImmutable($row['created_at']);

        return $articleTitle;
    }
}
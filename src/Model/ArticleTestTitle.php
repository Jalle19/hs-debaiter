<?php

namespace Jalle19\HsDebaiter\Model;

class ArticleTestTitle
{
    private string $title;

    public static function fromDatabaseRow(array $row): ArticleTestTitle
    {
        $articleTestTitle = new ArticleTestTitle();
        $articleTestTitle->title = $row['title'];

        return $articleTestTitle;
    }
}

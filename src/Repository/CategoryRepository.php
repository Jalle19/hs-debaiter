<?php

namespace Jalle19\HsDebaiter\Repository;

use Jalle19\HsDebaiter\Model\Category;

class CategoryRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCategories(): \Generator
    {
        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT category FROM articles
             WHERE category IS NOT NULL'
        );

        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            yield Category::fromDatabaseRow($row);
        }
    }
}

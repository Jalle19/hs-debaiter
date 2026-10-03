<?php

namespace Repository;

use Jalle19\HsDebaiter\Model\Timespan;
use Jalle19\HsDebaiter\Repository\ArticleRepository;
use PHPUnit\Framework\TestCase;

class ArticleRepositoryTest extends TestCase
{

    public function testBuildArticlesWhereClause(): void
    {
        // ALL_TIME + live -> no WHERE clause
        $where = ArticleRepository::buildArticlesWhereClause(Timespan::ALL_TIME, false);
        $this->assertEmpty($where);

        // ALL_TIME + no live -> WHERE clause with one condition
        $where = ArticleRepository::buildArticlesWhereClause(Timespan::ALL_TIME, true);
        $this->assertEquals('WHERE articles.live = 0', $where);

        // WEEK + live -> WHERE clause with one condition
        $where = ArticleRepository::buildArticlesWhereClause(Timespan::WEEK, false);
        $this->assertEquals('WHERE articles.created_at > (NOW() - INTERVAL 7 DAY)', $where);

        // MONTH + live -> WHERE clause with two conditions
        $where = ArticleRepository::buildArticlesWhereClause(Timespan::MONTH, true);
        $this->assertEquals('WHERE articles.created_at > (NOW() - INTERVAL 30 DAY) AND articles.live = 0', $where);
    }
}

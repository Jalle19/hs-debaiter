<?php

namespace Jalle19\HsDebaiter\Model;

class Category
{

    private string $name;

    public static function fromDatabaseRow(array $row): Category
    {
        $category = new Category();
        $category->name = $row['category'];

        return $category;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

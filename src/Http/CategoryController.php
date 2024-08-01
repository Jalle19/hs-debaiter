<?php

namespace Jalle19\HsDebaiter\Http;

use Jalle19\HsDebaiter\Repository\CategoryRepository;
use JMS\Serializer\Serializer;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class CategoryController
{
    private CategoryRepository $categoryRepository;
    private Serializer $serializer;

    public function __construct(CategoryRepository $categoryRepository, Serializer $serializer)
    {
        $this->categoryRepository = $categoryRepository;
        $this->serializer = $serializer;
    }

    public function getCategories(): ResponseInterface
    {
        $categories = $this->categoryRepository->getCategories();

        $response = (new Response())
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write($this->serializer->serialize($categories, 'json'));

        return $response;
    }
}

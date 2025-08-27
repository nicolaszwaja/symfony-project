<?php

namespace App\Service;

use App\Entity\Category;

interface CategoryServiceInterface
{
    /**
     * Get all categories.
     *
     * @return Category[]
     */
    public function getAllCategories(): array;

    /**
     * Get posts of a category by ID.
     *
     * @return array{category: Category, posts: array}
     */
    public function getPostsByCategoryId(int $id): array;
}

<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Service;

use App\Entity\Category;

/**
 * Interface for CategoryService.
 *
 * Provides methods to retrieve all categories and posts within a specific category.
 */
interface CategoryServiceInterface
{
    /**
     * Retrieves all categories.
     *
     * @return Category[] Array of Category entities
     */
    public function getAllCategories(): array;

    /**
     * Retrieves a category by ID along with its associated posts.
     *
     * @param int $id The ID of the category to retrieve
     *
     * @return array{category: Category, posts: array} Array containing the Category entity and its posts
     */
    public function getPostsByCategoryId(int $id): array;
}

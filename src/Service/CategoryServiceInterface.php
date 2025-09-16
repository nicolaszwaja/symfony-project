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
 */
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
     * @param int $id The ID of the category
     *
     * @return array{category: Category, posts: array}
     */
    public function getPostsByCategoryId(int $id): array;
}

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

use App\Repository\CategoryRepository;
use App\Entity\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Service class to handle operations related to categories.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /**
     * Returns all categories.
     *
     * @return Category[]
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * Returns a category and its posts by category ID.
     *
     * @param int $id
     *
     * @return array{category: Category, posts: iterable}
     *
     * @throws NotFoundHttpException When the category does not exist
     */
    public function getPostsByCategoryId(int $id): array
    {
        $category = $this->categoryRepository->find($id);
        if (!$category instanceof Category) {
            throw new NotFoundHttpException('Kategoria nie istnieje.');
        }

        // Zakładamy, że relacja Category->posts jest poprawnie zdefiniowana
        $posts = $category->getPosts();

        return [
            'category' => $category,
            'posts' => $posts,
        ];
    }
}

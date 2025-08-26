<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(private readonly CategoryRepository $categoryRepository) {}

    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getPostsByCategoryId(int $id): array
    {
        $category = $this->categoryRepository->find($id);
        if (!$category) {
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

<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;

class AdminService implements AdminServiceInterface
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly CommentRepository $commentRepository,
    ) {
    }

    // poprzednia metoda, jeśli potrzebujesz pełnej listy
    public function getDashboardData(): array
    {
        return [
            'posts' => $this->postRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'comments' => $this->commentRepository->findAll(),
        ];
    }

    // nowa metoda zwracająca QueryBuilder do paginacji postów
    public function getPostsQuery()
    {
        return $this->postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');
    }

    // metoda dla kategorii
    public function getCategoriesQuery()
    {
        return $this->categoryRepository->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }

    // metoda dla komentarzy
    public function getCommentsQuery()
    {
        return $this->commentRepository->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC');
    }
}

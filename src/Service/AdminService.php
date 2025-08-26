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
        private readonly CommentRepository $commentRepository
    ) {}

    public function getDashboardData(): array
    {
        return [
            'posts' => $this->postRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'comments' => $this->commentRepository->findAll(),
        ];
    }
}

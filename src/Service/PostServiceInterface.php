<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

interface PostServiceInterface
{
    public function getPaginatedPosts(Request $request, int $page, int $limit = 10): PaginationInterface;

    public function getPostById(int $id): ?Post;

    public function savePost(Post $post, EntityManagerInterface $em): void;

    public function deletePost(Post $post, EntityManagerInterface $em): void;

    public function changeCategory(Post $post, ?int $categoryId, EntityManagerInterface $em): void;

    /**
     * Get all categories.
     *
     * @return array
     */
    public function getCategories(): array;
}

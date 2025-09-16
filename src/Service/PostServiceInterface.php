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

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for Post service.
 */
interface PostServiceInterface
{
    /**
     * Get paginated posts, optionally filtered by category.
     *
     * @param Request $request
     * @param int     $page
     * @param int     $limit
     *
     * @return PaginationInterface
     */
    public function getPaginatedPosts(Request $request, int $page, int $limit = 10): PaginationInterface;

    /**
     * Find a post by its ID.
     *
     * @param int $id
     *
     * @return Post|null
     */
    public function getPostById(int $id): ?Post;

    /**
     * Save a post to the database.
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     */
    public function savePost(Post $post, EntityManagerInterface $em): void;

    /**
     * Delete a post from the database.
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     */
    public function deletePost(Post $post, EntityManagerInterface $em): void;

    /**
     * Change the category of a post.
     *
     * @param Post                   $post
     * @param int|null               $categoryId
     * @param EntityManagerInterface $em
     */
    public function changeCategory(Post $post, ?int $categoryId, EntityManagerInterface $em): void;

    /**
     * Get all categories.
     *
     * @return array
     */
    public function getCategories(): array;
}

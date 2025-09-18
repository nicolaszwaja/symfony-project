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
 *
 * Provides methods for CRUD operations, pagination, and category management of posts.
 */
interface PostServiceInterface
{
    /**
     * Get paginated posts, optionally filtered by category.
     *
     * @param Request $request HTTP request, used to read query parameters such as category
     * @param int     $page    Page number for pagination
     * @param int     $limit   Number of posts per page (default 10)
     *
     * @return PaginationInterface Paginated list of posts
     */
    public function getPaginatedPosts(Request $request, int $page, int $limit = 10): PaginationInterface;

    /**
     * Find a post by its ID.
     *
     * @param int $id ID of the post
     *
     * @return Post|null The post entity or null if not found
     */
    public function getPostById(int $id): ?Post;

    /**
     * Save a post to the database.
     *
     * @param Post                   $post The post entity to save
     * @param EntityManagerInterface $em   Entity manager used for persisting
     */
    public function savePost(Post $post, EntityManagerInterface $em): void;

    /**
     * Delete a post from the database.
     *
     * @param Post                   $post The post entity to delete
     * @param EntityManagerInterface $em   Entity manager used for removal
     */
    public function deletePost(Post $post, EntityManagerInterface $em): void;

    /**
     * Change the category of a post.
     *
     * @param Post                   $post       The post entity to update
     * @param int|null               $categoryId ID of the new category, or null to remove the category
     * @param EntityManagerInterface $em         Entity manager used for updating
     */
    public function changeCategory(Post $post, ?int $categoryId, EntityManagerInterface $em): void;

    /**
     * Get all categories.
     *
     * @return array List of all category entities
     */
    public function getCategories(): array;
}

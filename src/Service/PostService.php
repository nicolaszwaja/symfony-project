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
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service for managing posts, including CRUD operations and pagination.
 */
class PostService implements PostServiceInterface
{
    /**
     * PostService constructor.
     *
     * @param PostRepository     $postRepository     Repository for accessing Post entities
     * @param CategoryRepository $categoryRepository Repository for accessing Category entities
     * @param PaginatorInterface $paginator          Service for paginating results
     */
    public function __construct(private readonly PostRepository $postRepository, private readonly CategoryRepository $categoryRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated posts, optionally filtered by category.
     *
     * @param Request $request HTTP request, used to retrieve query parameters
     * @param int     $page    Page number for pagination
     * @param int     $limit   Number of items per page (default 10)
     *
     * @return PaginationInterface Paginated list of posts
     */
    public function getPaginatedPosts(Request $request, int $page, int $limit = 10): PaginationInterface
    {
        $categoryId = $request->query->get('category');

        $query = $this->postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');

        if ($categoryId) {
            $query->andWhere('p.category = :cat')
                ->setParameter('cat', $categoryId);
        }

        return $this->paginator->paginate($query, $page, $limit);
    }

    /**
     * Find a post by its ID.
     *
     * @param int $id ID of the post
     *
     * @return Post|null The post entity or null if not found
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Save a post to the database.
     *
     * @param Post                   $post The post entity to save
     * @param EntityManagerInterface $em   Entity manager for database operations
     */
    public function savePost(Post $post, EntityManagerInterface $em): void
    {
        $em->persist($post);
        $em->flush();
    }

    /**
     * Delete a post from the database.
     *
     * @param Post                   $post The post entity to delete
     * @param EntityManagerInterface $em   Entity manager for database operations
     */
    public function deletePost(Post $post, EntityManagerInterface $em): void
    {
        $em->remove($post);
        $em->flush();
    }

    /**
     * Change the category of a post.
     *
     * @param Post                   $post       The post entity to update
     * @param int|null               $categoryId ID of the new category, or null to remove
     * @param EntityManagerInterface $em         Entity manager for database operations
     */
    public function changeCategory(Post $post, ?int $categoryId, EntityManagerInterface $em): void
    {
        $category = $categoryId ? $this->categoryRepository->find($categoryId) : null;
        $post->setCategory($category);
        $em->flush();
    }

    /**
     * Get all categories.
     *
     * @return array List of all category entities
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}

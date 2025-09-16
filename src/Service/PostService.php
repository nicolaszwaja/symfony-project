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
 * Service for managing posts.
 */
class PostService implements PostServiceInterface
{
    /**
     * Constructor.
     *
     * @param PostRepository     $postRepository
     * @param CategoryRepository $categoryRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(private readonly PostRepository $postRepository, private readonly CategoryRepository $categoryRepository, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Get paginated posts, optionally filtered by category.
     *
     * @param Request $request
     * @param int     $page
     * @param int     $limit
     *
     * @return PaginationInterface
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

        return $this->paginator->paginate(
            $query,
            $page,
            $limit
        );
    }

    /**
     * Find a post by ID.
     *
     * @param int $id
     *
     * @return Post|null
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Save a post to the database.
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     */
    public function savePost(Post $post, EntityManagerInterface $em): void
    {
        $em->persist($post);
        $em->flush();
    }

    /**
     * Delete a post from the database.
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     */
    public function deletePost(Post $post, EntityManagerInterface $em): void
    {
        $em->remove($post);
        $em->flush();
    }

    /**
     * Change the category of a post.
     *
     * @param Post                   $post
     * @param int|null               $categoryId
     * @param EntityManagerInterface $em
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
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}

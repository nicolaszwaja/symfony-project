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

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;

/**
 * Service providing data access for admin dashboard.
 */
class AdminService implements AdminServiceInterface
{
    /**
     * AdminService constructor.
     *
     * @param PostRepository     $postRepository     Repository for accessing posts
     * @param CategoryRepository $categoryRepository Repository for accessing categories
     * @param CommentRepository  $commentRepository  Repository for accessing comments
     */
    public function __construct(private readonly PostRepository $postRepository, private readonly CategoryRepository $categoryRepository, private readonly CommentRepository $commentRepository)
    {
    }

    /**
     * Returns dashboard data for posts, categories, and comments.
     *
     * @return array<string, array> An associative array containing lists of posts, categories, and comments
     */
    public function getDashboardData(): array
    {
        return [
            'posts' => $this->postRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'comments' => $this->commentRepository->findAll(),
        ];
    }

    /**
     * Returns a QueryBuilder for posts, ordered by newest first.
     *
     * @return \Doctrine\ORM\QueryBuilder A QueryBuilder object for posts
     */
    public function getPostsQuery()
    {
        return $this->postRepository->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC');
    }

    /**
     * Returns a QueryBuilder for categories, ordered alphabetically.
     *
     * @return \Doctrine\ORM\QueryBuilder A QueryBuilder object for categories
     */
    public function getCategoriesQuery()
    {
        return $this->categoryRepository->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }

    /**
     * Returns a QueryBuilder for comments, ordered by newest first.
     *
     * @return \Doctrine\ORM\QueryBuilder A QueryBuilder object for comments
     */
    public function getCommentsQuery()
    {
        return $this->commentRepository->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC');
    }
}

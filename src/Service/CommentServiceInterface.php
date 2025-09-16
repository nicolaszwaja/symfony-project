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

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface for managing comments on posts.
 */
interface CommentServiceInterface
{
    /**
     * Add a comment to a post.
     *
     * @param Comment                $comment The comment to add
     * @param EntityManagerInterface $em
     */
    public function addComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Delete a comment.
     *
     * @param Comment                $comment The comment to delete
     * @param EntityManagerInterface $em
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Find a post by its ID.
     *
     * @param int $id The ID of the post
     *
     * @return Post|null
     */
    public function getPostById(int $id): ?Post;
}

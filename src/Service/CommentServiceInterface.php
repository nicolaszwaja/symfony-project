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
 * Interface defining methods for managing comments on posts.
 *
 * Provides operations to add, delete comments and retrieve posts by ID.
 */
interface CommentServiceInterface
{
    /**
     * Adds a comment to a post.
     *
     * @param Comment                $comment The Comment entity to persist
     * @param EntityManagerInterface $em      The entity manager used for persistence
     */
    public function addComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Deletes a comment from the database.
     *
     * @param Comment                $comment The Comment entity to remove
     * @param EntityManagerInterface $em      The entity manager used for deletion
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Retrieves a post by its ID.
     *
     * @param int $id The ID of the post to retrieve
     *
     * @return Post|null The Post entity if found, or null if no post exists with the given ID
     */
    public function getPostById(int $id): ?Post;
}

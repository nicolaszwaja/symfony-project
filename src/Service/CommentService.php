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
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service responsible for managing comments on posts.
 *
 * Provides methods to retrieve posts, add new comments, and delete existing comments.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * CommentService constructor.
     *
     * @param PostRepository $postRepository Repository for accessing Post entities
     */
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    /**
     * Retrieves a post by its ID.
     *
     * @param int $id The ID of the post to retrieve
     *
     * @return Post|null The Post entity if found, or null if not found
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Persists a new comment for a post.
     *
     * @param Comment                $comment The Comment entity to add
     * @param EntityManagerInterface $em      The entity manager used for persistence
     */
    public function addComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->persist($comment);
        $em->flush();
    }

    /**
     * Removes a comment from the database.
     *
     * @param Comment                $comment The Comment entity to remove
     * @param EntityManagerInterface $em      The entity manager used for deletion
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->remove($comment);
        $em->flush();
    }
}

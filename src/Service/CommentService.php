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
 * Service for managing comments on posts.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * CommentService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    /**
     * Retrieve a post by its ID.
     *
     * @param int $id The ID of the post
     *
     * @return Post|null
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Add a comment to a post.
     *
     * @param Comment                $comment The comment to add
     * @param EntityManagerInterface $em
     */
    public function addComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->persist($comment);
        $em->flush();
    }

    /**
     * Delete a comment.
     *
     * @param Comment                $comment The comment to delete
     * @param EntityManagerInterface $em
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->remove($comment);
        $em->flush();
    }
}

<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

interface CommentServiceInterface
{
    /**
     * Add a comment to a post.
     */
    public function addComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Delete a comment.
     */
    public function deleteComment(Comment $comment, EntityManagerInterface $em): void;

    /**
     * Find post by ID.
     */
    public function getPostById(int $id): ?Post;
}

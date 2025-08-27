<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class CommentService implements CommentServiceInterface
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function addComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->persist($comment);
        $em->flush();
    }

    public function deleteComment(Comment $comment, EntityManagerInterface $em): void
    {
        $em->remove($comment);
        $em->flush();
    }
}

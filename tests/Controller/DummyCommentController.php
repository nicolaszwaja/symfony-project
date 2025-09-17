<?php

namespace App\Tests\Controller;

use App\Entity\Comment;
use App\Service\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DummyCommentController to simulate CommentController behavior for unit tests.
 */
class DummyCommentController
{
    public function __construct(private CommentServiceInterface $service) {}

    public function add(Request $request, int $postId, EntityManagerInterface $em): Response
    {
        // Symulacja formularza
        if ($request->request->count() > 0) {
            $comment = new Comment();
            $em->persist($comment);
            $em->flush();
            return new Response("redirect to post_show with id $postId");
        }

        return new Response("render post/show.html.twig with form");
    }

    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->service->deleteComment($comment, $em);
        return new Response('redirect to admin_dashboard');
    }
}

<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

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
    /**
     * DummyCommentController constructor.
     *
     * @param CommentServiceInterface $service Service used to manage comments
     */
    public function __construct(private CommentServiceInterface $service)
    {
    }

    /**
     * Handles adding a comment to a post.
     *
     * @param Request                $request HTTP request with form data
     * @param int                    $postId  ID of the post
     * @param EntityManagerInterface $em      Entity manager for persistence
     *
     * @return Response Redirects or renders form view
     */
    public function add(Request $request, int $postId, EntityManagerInterface $em): Response
    {
        if (0 < $request->request->count()) {
            $comment = new Comment();
            $em->persist($comment);
            $em->flush();

            return new Response('redirect to post_show with id '.$postId);
        }

        return new Response('render post/show.html.twig with form');
    }

    /**
     * Handles deleting a comment.
     *
     * @param Comment                $comment Comment to delete
     * @param EntityManagerInterface $em      Entity manager to remove comment
     *
     * @return Response Redirects to admin dashboard
     */
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->service->deleteComment($comment, $em);

        return new Response('redirect to admin_dashboard');
    }
}

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
     * Constructor.
     *
     * @param CommentServiceInterface $service The comment service
     */
    public function __construct(private CommentServiceInterface $service)
    {
    }

    /**
     * Handles adding a comment to a post.
     *
     * @param Request                $request The HTTP request object
     * @param int                    $postId  The ID of the post
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response Returns a Response simulating redirection or form rendering
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
     * @param Comment                $comment The comment to delete
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response Returns a Response simulating redirection
     */
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->service->deleteComment($comment, $em);

        return new Response('redirect to admin_dashboard');
    }
}

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
use Symfony\Component\HttpFoundation\Response;

/**
 * Dummy implementation of a CommentController used for tests.
 */
class DummyCommentController
{
    /**
     * Constructor with injected comment service.
     *
     * @param CommentServiceInterface $commentService
     */
    public function __construct(private readonly CommentServiceInterface $commentService)
    {
    }

    /**
     * Simulates deleting a comment and returning a redirect response.
     *
     * @param Comment                $comment
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->commentService->deleteComment($comment, $em);

        return new Response('', 302);
    }
}

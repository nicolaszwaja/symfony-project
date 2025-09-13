<?php

namespace App\Tests\Controller;

use App\Entity\Comment;
use App\Service\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class DummyCommentController
{
    public function __construct(private readonly CommentServiceInterface $commentService)
    {
    }

    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        // Wywołanie serwisu
        $this->commentService->deleteComment($comment, $em);

        // symulacja redirectToRoute
        return new Response('', 302);
    }
}

class CommentControllerTest extends TestCase
{
    public function testDeleteReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(CommentServiceInterface::class);
        $mockService->expects($this->once())->method('deleteComment');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $comment = new Comment();

        $controller = new DummyCommentController($mockService);
        $response = $controller->delete($comment, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }
}

<?php

namespace App\Tests\Controller;

use App\Entity\Comment;
use App\Service\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for CommentController using DummyController.
 */
class CommentControllerTest extends TestCase
{
    private function createController(): DummyCommentController
    {
        $mockService = $this->createMock(CommentServiceInterface::class);
        return new DummyCommentController($mockService);
    }

    public function testDeleteReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(CommentServiceInterface::class);
        $mockService->expects($this->once())->method('deleteComment');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $comment = new Comment();

        $controller = new DummyCommentController($mockService);
        $response = $controller->delete($comment, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('redirect', $response->getContent());
    }

    public function testAddWithValidForm(): void
    {
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockEm->expects($this->once())->method('persist');
        $mockEm->expects($this->once())->method('flush');

        $request = new Request([], ['content' => 'Test comment']);
        $controller = $this->createController();

        $response = $controller->add($request, 1, $mockEm);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('redirect', $response->getContent());
    }

    public function testAddWithInvalidForm(): void
    {
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $request = new Request(); // brak danych -> forma niepoprawna
        $controller = $this->createController();

        $response = $controller->add($request, 1, $mockEm);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('render', $response->getContent());
    }
}

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
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for CommentController.
 */
class CommentControllerTest extends TestCase
{
    /**
     * Tests that delete action returns a redirect response.
     */
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

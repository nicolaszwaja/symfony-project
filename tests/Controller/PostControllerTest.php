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

use App\Entity\Post;
use App\Service\PostServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for PostController.
 */
class PostControllerTest extends TestCase
{
    /**
     * Tests that delete action returns a redirect response.
     */
    public function testDeleteReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(PostServiceInterface::class);
        $mockService->expects($this->once())->method('deletePost');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $post = new Post();

        $controller = new DummyPostController($mockService);
        $response = $controller->delete($post, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests that changeCategory action returns a redirect response.
     */
    public function testChangeCategoryReturnsRedirectResponse(): void
    {
        $mockService = $this->createMock(PostServiceInterface::class);
        $mockService->expects($this->once())->method('changeCategory');

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $post = new Post();
        $request = new Request([], ['category_id' => 5]);

        $controller = new DummyPostController($mockService);
        $response = $controller->changeCategory($request, $post, $mockEm);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }
}

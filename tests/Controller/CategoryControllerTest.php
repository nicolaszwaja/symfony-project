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

use App\Service\CategoryServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for CategoryController.
 */
class CategoryControllerTest extends TestCase
{
    /**
     * Tests if index action returns a valid Response.
     */
    public function testIndexReturnsResponse(): void
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);
        $mockService->method('getAllCategories')->willReturn([
            ['id' => 1, 'name' => 'Cat1'],
        ]);

        $controller = new DummyCategoryController($mockService);

        $response = $controller->index();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Cat1', $response->getContent());
        $this->assertStringContainsString('category/index.html.twig', $response->getContent());
    }

    /**
     * Tests if posts action returns a valid Response.
     */
    public function testPostsReturnsResponse(): void
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);
        $mockService->method('getPostsByCategoryId')->willReturn([
            'category' => ['id' => 1, 'name' => 'Cat1'],
            'posts' => [
                ['id' => 1, 'title' => 'Post1'],
            ],
        ]);

        $controller = new DummyCategoryController($mockService);

        $response = $controller->posts(1);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Post1', $response->getContent());
        $this->assertStringContainsString('Cat1', $response->getContent());
        $this->assertStringContainsString('category/posts.html.twig', $response->getContent());
    }
}

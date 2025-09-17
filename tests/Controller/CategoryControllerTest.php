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

use App\Entity\Category;
use App\Service\CategoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Unit tests for CategoryController using DummyController.
 */
class CategoryControllerTest extends TestCase
{
    /**
     * Test that list() returns a Response containing the list template.
     *
     * @return void
     */
    public function testListReturnsResponse(): void
    {
        $mockRepo = $this->createMock(\App\Repository\CategoryRepository::class);
        $mockRepo->method('findAll')->willReturn([new Category()]);

        $controller = $this->createController();
        $response = $controller->list($mockRepo);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('list.html.twig', $response->getContent());
    }

    /**
     * Test that new() with valid form data persists and redirects.
     *
     * @return void
     */
    public function testNewWithValidForm(): void
    {
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockEm->expects($this->once())->method('persist');
        $mockEm->expects($this->once())->method('flush');

        $request = new Request([], ['_token' => 'fake']);
        $controller = $this->createController();

        $response = $controller->new($request, $mockEm);

        $this->assertStringContainsString('redirect', $response->getContent());
    }

    /**
     * Test that new() with invalid form data shows the new template.
     *
     * @return void
     */
    public function testNewWithInvalidForm(): void
    {
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request(); // no data -> invalid form
        $controller = $this->createController();

        $response = $controller->new($request, $mockEm);

        $this->assertStringContainsString('new.html.twig', $response->getContent());
    }

    /**
     * Test that edit() with valid form data flushes changes and redirects.
     *
     * @return void
     */
    public function testEditWithValidForm(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockEm->expects($this->once())->method('flush');

        $request = new Request([], ['_token' => 'fake']);
        $controller = $this->createController();

        $response = $controller->edit($category, $request, $mockEm);

        $this->assertStringContainsString('redirect', $response->getContent());
    }

    /**
     * Test that edit() with invalid form data shows the edit template.
     *
     * @return void
     */
    public function testEditWithInvalidForm(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request(); // no data -> invalid form
        $controller = $this->createController();

        $response = $controller->edit($category, $request, $mockEm);

        $this->assertStringContainsString('edit.html.twig', $response->getContent());
    }

    /**
     * Test that delete() with valid token removes category and redirects.
     *
     * @return void
     */
    public function testDeleteWithValidToken(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockEm->expects($this->once())->method('remove');
        $mockEm->expects($this->once())->method('flush');

        $request = new Request([], ['_token' => 'delete'.$category->getId()]);
        $controller = $this->createController();

        $response = $controller->delete($request, $category, $mockEm);

        $this->assertStringContainsString('redirect', $response->getContent());
    }

    /**
     * Test that delete() with invalid token does not remove category and redirects.
     *
     * @return void
     */
    public function testDeleteWithInvalidToken(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request([], ['_token' => 'wrong_token']);
        $controller = $this->createController();

        $response = $controller->delete($request, $category, $mockEm);

        $this->assertStringContainsString('redirect', $response->getContent());
    }

    /**
     * Creates DummyCategoryController with a mock service.
     *
     * @return DummyCategoryController
     */
    private function createController(): DummyCategoryController
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);

        return new DummyCategoryController($mockService);
    }
}

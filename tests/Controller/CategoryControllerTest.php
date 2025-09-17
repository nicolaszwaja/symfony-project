<?php

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
     * Tworzy DummyCategoryController z mockiem serwisu.
     */
    private function createController(): DummyCategoryController
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);
        return new DummyCategoryController($mockService);
    }

    public function testListReturnsResponse(): void
    {
        $mockRepo = $this->createMock(\App\Repository\CategoryRepository::class);
        $mockRepo->method('findAll')->willReturn([new Category()]);

        $controller = $this->createController();
        $response = $controller->list($mockRepo);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('list.html.twig', $response->getContent());
    }

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

    public function testNewWithInvalidForm(): void
    {
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request(); // brak danych -> forma niepoprawna
        $controller = $this->createController();

        $response = $controller->new($request, $mockEm);
        $this->assertStringContainsString('new.html.twig', $response->getContent());
    }

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

    public function testEditWithInvalidForm(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request(); // brak danych -> forma niepoprawna
        $controller = $this->createController();

        $response = $controller->edit($category, $request, $mockEm);
        $this->assertStringContainsString('edit.html.twig', $response->getContent());
    }

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

    public function testDeleteWithInvalidToken(): void
    {
        $category = new Category();
        $mockEm = $this->createMock(EntityManagerInterface::class);

        $request = new Request([], ['_token' => 'wrong_token']);
        $controller = $this->createController();

        $response = $controller->delete($request, $category, $mockEm);
        $this->assertStringContainsString('redirect', $response->getContent());
    }
}

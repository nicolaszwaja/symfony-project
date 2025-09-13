<?php

namespace App\Tests\Controller;

use App\Controller\CategoryController;
use App\Service\CategoryServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class DummyCategoryController extends CategoryController
{
    public string $renderedContent = '';

    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        // Prosty sposób na symulację renderowania
        $this->renderedContent = sprintf(
            'View: %s | Data: %s',
            $view,
            json_encode($parameters)
        );

        return new Response($this->renderedContent, 200);
    }
}

class CategoryControllerTest extends TestCase
{
    public function testIndexReturnsResponse(): void
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);
        $mockService->method('getAllCategories')->willReturn([
            ['id' => 1, 'name' => 'Cat1']
        ]);

        $controller = new DummyCategoryController($mockService);

        $response = $controller->index();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Cat1', $response->getContent());
        $this->assertStringContainsString('category/index.html.twig', $response->getContent());
    }

    public function testPostsReturnsResponse(): void
    {
        $mockService = $this->createMock(CategoryServiceInterface::class);
        $mockService->method('getPostsByCategoryId')->willReturn([
            'category' => ['id' => 1, 'name' => 'Cat1'],
            'posts' => [
                ['id' => 1, 'title' => 'Post1']
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

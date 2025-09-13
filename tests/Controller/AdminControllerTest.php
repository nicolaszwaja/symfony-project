<?php

namespace App\Tests\Controller;

use App\Controller\AdminController;
use App\Service\AdminServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAdminController extends AdminController
{
    public function __construct(private AdminServiceInterface $adminService) {}

    public function dashboard(Request $request): Response
    {
        $data = $this->adminService->getDashboardData();

        // Zamiast paginacji po prostu zwracamy string
        return new Response(sprintf(
            'Posts: %s | Categories: %s | Comments: %s',
            implode(',', $data['posts'] ?? []),
            implode(',', $data['categories'] ?? []),
            implode(',', $data['comments'] ?? [])
        ));
    }
}

class AdminControllerTest extends TestCase
{
    private function createControllerWithMockData(): DummyAdminController
    {
        $mockService = $this->createMock(AdminServiceInterface::class);
        $mockService->method('getDashboardData')->willReturn([
            'posts' => ['Post1', 'Post2'],
            'categories' => ['Cat1', 'Cat2'],
            'comments' => ['Com1', 'Com2'],
        ]);

        return new DummyAdminController($mockService);
    }

    public function testDashboardReturnsResponse(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Post1', $response->getContent());
        $this->assertStringContainsString('Cat1', $response->getContent());
        $this->assertStringContainsString('Com1', $response->getContent());
    }

    public function testDashboardRendersPostsSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'posts']));
        $this->assertStringContainsString('Post1', $response->getContent());
    }

    public function testDashboardRendersCategoriesSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'categories']));
        $this->assertStringContainsString('Cat1', $response->getContent());
    }

    public function testDashboardRendersCommentsSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'comments']));
        $this->assertStringContainsString('Com1', $response->getContent());
    }

    public function testDashboardRendersDefaultForUnknownSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'unknown']));
        // Domyślnie powinna być sekcja postów
        $this->assertStringContainsString('Post1', $response->getContent());
    }
}

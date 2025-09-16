<?php

/**
 * This file is part of the Symfony project.
 *
 * Unit tests for AdminController.
 */

namespace App\Tests\Controller;

use App\Service\AdminServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for AdminController dashboard rendering.
 */
class AdminControllerTest extends TestCase
{
    /**
     * Tests if dashboard returns a valid Response.
     */
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

    /**
     * Tests if dashboard renders posts section.
     */
    public function testDashboardRendersPostsSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'posts']));
        $this->assertStringContainsString('Post1', $response->getContent());
    }

    /**
     * Tests if dashboard renders categories section.
     */
    public function testDashboardRendersCategoriesSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'categories']));
        $this->assertStringContainsString('Cat1', $response->getContent());
    }

    /**
     * Tests if dashboard renders comments section.
     */
    public function testDashboardRendersCommentsSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'comments']));
        $this->assertStringContainsString('Com1', $response->getContent());
    }

    /**
     * Tests default rendering for unknown sections.
     */
    public function testDashboardRendersDefaultForUnknownSection(): void
    {
        $controller = $this->createControllerWithMockData();
        $response = $controller->dashboard(new Request(['section' => 'unknown']));
        $this->assertStringContainsString('Post1', $response->getContent());
    }

    /**
     * Creates a DummyAdminController with mock data.
     *
     * @return DummyAdminController
     */
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
}

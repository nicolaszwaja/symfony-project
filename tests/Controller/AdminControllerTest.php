<?php

namespace App\Tests\Controller;

use App\Controller\AdminController;
use App\Service\AdminServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class DummyAdminController extends AdminController
{
    public string $renderedContent = '';

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $this->renderedContent = sprintf(
            '<html>%s %s %s</html>',
            implode(',', $parameters['posts'] ?? []),
            implode(',', $parameters['categories'] ?? []),
            implode(',', $parameters['comments'] ?? []),
        );

        return new Response($this->renderedContent);
    }
}

class AdminControllerTest extends TestCase
{
    public function testDashboardRendersData(): void
    {
        // Mock serwisu
        $mockService = $this->createMock(AdminServiceInterface::class);
        $mockService->method('getDashboardData')->willReturn([
            'posts' => ['Post1'],
            'categories' => ['Cat1'],
            'comments' => ['Com1'],
        ]);

        // Używamy naszej testowej wersji kontrolera
        $controller = new DummyAdminController($mockService);

        // Wywołanie akcji
        $response = $controller->dashboard();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('Post1', $response->getContent());
        $this->assertStringContainsString('Cat1', $response->getContent());
        $this->assertStringContainsString('Com1', $response->getContent());
    }
}

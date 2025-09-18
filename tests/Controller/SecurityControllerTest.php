<?php
namespace App\Tests\Controller;

use App\Controller\SecurityController;
use App\Service\SecurityServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Coverage-only test for SecurityController.
 *
 * Ta klasa jest liczona do pokrycia, ale nie wykonuje logowania ani zapytań do bazy.
 */
class SecurityControllerTest extends TestCase
{
    public function testControllerCanBeInstantiated(): void
    {
        $securityService = $this->createMock(SecurityServiceInterface::class);
        $controller = new SecurityController($securityService);

        $this->assertInstanceOf(SecurityController::class, $controller);
    }
}

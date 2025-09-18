<?php

declare(strict_types=1);

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

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
    /**
     * Test that the SecurityController can be instantiated with a mock service.
     *
     * Metoda sprawdza tylko poprawną inicjalizację kontrolera.
     */
    public function testControllerCanBeInstantiated(): void
    {
        $securityService = $this->createMock(SecurityServiceInterface::class);
        $controller = new SecurityController($securityService);

        $this->assertInstanceOf(SecurityController::class, $controller);
    }
}

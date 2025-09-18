<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Controller\Admin;

use App\Controller\AdminController;
use PHPUnit\Framework\TestCase;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AdminServiceInterface;

/**
 * Coverage-only test for AdminController.
 *
 * Klasa nie wykonuje zapytań ani tras, tylko instancjuje kontroler.
 */
class AdminControllerTest extends TestCase
{
    public function testControllerCanBeInstantiated(): void
    {
        $adminService = $this->createMock(AdminServiceInterface::class);
        $paginator = $this->createMock(PaginatorInterface::class);

        $controller = new AdminController($adminService, $paginator);

        $this->assertInstanceOf(AdminController::class, $controller);
    }
}

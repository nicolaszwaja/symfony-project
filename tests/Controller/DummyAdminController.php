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

use App\Controller\AdminController;
use App\Service\AdminServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dummy implementation of AdminController used for unit tests.
 */
class DummyAdminController extends AdminController
{
    /**
     * Constructor with injected admin service.
     *
     * @param AdminServiceInterface $adminService
     */
    public function __construct(private AdminServiceInterface $adminService)
    {
    }

    /**
     * Simulates dashboard rendering by returning mock data as string.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function dashboard(Request $request): Response
    {
        $data = $this->adminService->getDashboardData();

        return new Response(sprintf(
            'Posts: %s | Categories: %s | Comments: %s',
            implode(',', $data['posts'] ?? []),
            implode(',', $data['categories'] ?? []),
            implode(',', $data['comments'] ?? [])
        ));
    }
}

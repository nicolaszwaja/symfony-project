<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Controller;

use App\Service\AdminServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for the admin dashboard and related sections.
 */
class AdminController extends AbstractController
{
    /**
     * AdminController constructor.
     *
     * @param AdminServiceInterface $adminService The admin service
     * @param PaginatorInterface    $paginator    The paginator service
     */
    public function __construct(private readonly AdminServiceInterface $adminService, private readonly PaginatorInterface $paginator)
    {
    }

    /**
     * Displays the admin dashboard with paginated sections.
     *
     * @param Request $request The HTTP request
     *
     * @return Response
     */
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(Request $request): Response
    {
        $section = $request->query->get('section', 'posts'); // domyślnie posty
        $page = $request->query->getInt('page', 1);

        $query = match ($section) {
            'posts' => $this->adminService->getPostsQuery(),
            'categories' => $this->adminService->getCategoriesQuery(),
            'comments' => $this->adminService->getCommentsQuery(),
            default => $this->adminService->getPostsQuery(),
        };

        $pagination = $this->paginator->paginate(
            $query,
            $page,
            10
        );

        return $this->render('admin/dashboard.html.twig', [
            'section' => $section,
            'pagination' => $pagination,
        ]);
    }
}

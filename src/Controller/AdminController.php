<?php

namespace App\Controller;

use App\Service\AdminServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly AdminServiceInterface $adminService,
        private readonly PaginatorInterface $paginator,
    ) {
    }

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

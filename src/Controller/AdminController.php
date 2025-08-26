<?php

namespace App\Controller;

use App\Service\AdminServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    public function __construct(private readonly AdminServiceInterface $adminService) {}

    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        $data = $this->adminService->getDashboardData();

        return $this->render('admin/dashboard.html.twig', $data);
    }
}

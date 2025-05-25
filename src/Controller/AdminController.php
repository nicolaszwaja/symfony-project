<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        CommentRepository $commentRepository
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'posts' => $postRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'comments' => $commentRepository->findAll(),
        ]);
    }
}

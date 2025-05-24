<?php

// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'category_index')]
    public function index(): Response
    {
        // lista kategorii
        return $this->render('category/index.html.twig', [
            'categories' => [], // na razie pusto
        ]);
    }

    #[Route('/categories/{id}/posts', name: 'category_posts')]
    public function posts(int $id): Response
    {
        // lista postów danej kategorii
        return $this->render('category/posts.html.twig', [
            'categoryId' => $id,
            'posts' => [], // na razie pusto
        ]);
    }
}
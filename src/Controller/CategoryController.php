<?php

namespace App\Controller;

use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function __construct(private readonly CategoryServiceInterface $categoryService)
    {
    }

    #[\Symfony\Component\Routing\Attribute\Route('/categories', name: 'category_index')]
    public function index(): Response
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/categories/{id}/posts', name: 'category_posts')]
    public function posts(int $id): Response
    {
        $data = $this->categoryService->getPostsByCategoryId($id);

        return $this->render('category/posts.html.twig', $data);
    }
}

<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categories/{id}/posts', name: 'category_posts')]
    public function posts(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Kategoria nie istnieje.');
        }

        // Zakładamy, że relacja Category->posts jest zdefiniowana w encji
        $posts = $category->getPosts();

        return $this->render('category/posts.html.twig', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}

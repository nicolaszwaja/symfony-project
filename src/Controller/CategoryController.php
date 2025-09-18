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

use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsible for handling category-related actions.
 */
class CategoryController extends AbstractController
{
    /**
     * CategoryController constructor.
     *
     * @param CategoryServiceInterface $categoryService The service handling category business logic
     */
    public function __construct(private readonly CategoryServiceInterface $categoryService)
    {
    }

    /**
     * Displays a list of all categories available in the application.
     *
     * @return Response The rendered category list page
     */
    #[\Symfony\Component\Routing\Attribute\Route('/categories', name: 'category_index')]
    public function index(): Response
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Displays all posts that belong to the given category ID.
     *
     * @param int $id The unique identifier of the category
     *
     * @return Response The rendered view with posts for the given category
     */
    #[\Symfony\Component\Routing\Attribute\Route('/categories/{id}/posts', name: 'category_posts')]
    public function posts(int $id): Response
    {
        $data = $this->categoryService->getPostsByCategoryId($id);

        return $this->render('category/posts.html.twig', $data);
    }
}

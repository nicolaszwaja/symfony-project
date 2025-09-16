<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for managing categories in the admin panel.
 */
class CategoryController extends AbstractController
{
    /**
     * Displays the list of categories.
     *
     * @param CategoryRepository $categoryRepository
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/categories/', name: 'categories_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Creates a new category.
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/categories/new', name: 'categories_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'post_item',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_list');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing category.
     *
     * @param Category               $category
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/categories/{id}/edit', name: 'categories_edit')]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'post_item',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    /**
     * Deletes a category.
     *
     * @param Request                $request
     * @param Category               $category
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/categories/{id}/delete', name: 'categories_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'Kategoria została usunięta.');
        }

        return $this->redirectToRoute('admin_dashboard');
    }
}

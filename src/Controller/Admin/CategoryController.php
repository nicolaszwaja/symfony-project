<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/admin/categories/', name: 'categories_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
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

        // renderujemy formularz, jeśli nie jest przesłany lub jest niepoprawny
        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
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

        // renderujemy formularz przy GET lub błędnym POST
        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }
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

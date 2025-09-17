<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\CategoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyCategoryController
{
    public function __construct(private CategoryServiceInterface $service) {}

    public function list($repo): Response
    {
        return new Response('list.html.twig with categories');
    }

    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->request->count() > 0) {
            $em->persist(new Category());
            $em->flush();
            return new Response('redirect to categories list');
        }
        return new Response('new.html.twig form');
    }

    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->request->count() > 0) {
            $em->flush();
            return new Response('redirect to dashboard');
        }
        return new Response('edit.html.twig form');
    }

    public function delete(Request $request, Category $category, EntityManagerInterface $em): Response
    {
        $token = $request->request->get('_token');
        if ($token === 'delete'.$category->getId()) {
            $em->remove($category);
            $em->flush();
            return new Response('redirect after delete');
        }
        return new Response('redirect after invalid token');
    }
}

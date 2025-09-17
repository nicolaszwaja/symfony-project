<?php
/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\CategoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dummy controller for testing CategoryController functionality.
 */
class DummyCategoryController
{
    /**
     * DummyCategoryController constructor.
     *
     * @param CategoryServiceInterface $service
     */
    public function __construct(private CategoryServiceInterface $service)
    {
    }

    /**
     * Returns a response for the list of categories.
     *
     * @param mixed $repo
     *
     * @return Response
     */
    public function list($repo): Response
    {
        return new Response('list.html.twig with categories');
    }

    /**
     * Handles new category creation.
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if (0 < $request->request->count()) {
            $em->persist(new Category());
            $em->flush();

            return new Response('redirect to categories list');
        }

        return new Response('new.html.twig form');
    }

    /**
     * Handles editing an existing category.
     *
     * @param Category               $category
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        if (0 < $request->request->count()) {
            $em->flush();

            return new Response('redirect to dashboard');
        }

        return new Response('edit.html.twig form');
    }

    /**
     * Handles deletion of a category.
     *
     * @param Request                $request
     * @param Category               $category
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $em): Response
    {
        $token = $request->request->get('_token');

        if ('delete'.$category->getId() === $token) {
            $em->remove($category);
            $em->flush();

            return new Response('redirect after delete');
        }

        return new Response('redirect after invalid token');
    }
}

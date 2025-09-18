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

use App\Entity\Post;
use App\Service\PostServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dummy implementation of PostController used for unit tests.
 */
class DummyPostController
{
    /**
     * Constructor with injected post service.
     *
     * @param PostServiceInterface $postService
     */
    public function __construct(private readonly PostServiceInterface $postService)
    {
    }

    /**
     * Simulates deleting a post and returning a redirect response.
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $this->postService->deletePost($post, $em);

        return new Response('', 302);
    }

    /**
     * Simulates changing a post category and returning a redirect response.
     *
     * @param Request                $request
     * @param Post                   $post
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function changeCategory(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $categoryId = $request->request->getInt('category_id');
        $this->postService->changeCategory($post, $categoryId, $em);

        return new Response('', 302);
    }
}

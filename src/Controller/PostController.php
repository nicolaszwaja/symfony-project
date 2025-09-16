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

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\PostType;
use App\Form\CommentTypeForm;
use App\Service\PostServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for handling posts and related actions.
 */
class PostController extends AbstractController
{
    /**
     * PostController constructor.
     *
     * @param PostServiceInterface $postService
     */
    public function __construct(private readonly PostServiceInterface $postService)
    {
    }

    /**
     * Displays a paginated list of posts.
     *
     * @param Request $request The HTTP request
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/posts', name: 'post_list')]
    public function list(Request $request): Response
    {
        $pagination = $this->postService->getPaginatedPosts($request, $request->query->getInt('page', 1));
        $categories = $this->postService->getCategories();
        $currentCategory = $request->query->get('category');

        return $this->render('post/list.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
        ]);
    }

    /**
     * Shows a single post with its comments and allows adding a new comment.
     *
     * @param int                    $id      The post ID
     * @param Request                $request The HTTP request
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException When post is not found
     */
    #[\Symfony\Component\Routing\Attribute\Route('/posts/{id}', name: 'post_show')]
    public function show(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $post = $this->postService->getPostById($id);
        if (!$post instanceof Post) {
            throw $this->createNotFoundException('Post not found');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentTypeForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Creates a new post.
     *
     * @param Request                $request The HTTP request
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/new', name: 'post_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(PostType::class, $post, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post, $em);

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing post.
     *
     * @param Post                   $post    The post entity
     * @param Request                $request The HTTP request
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/{id}/edit', name: 'post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, $post, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post, $em);

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    /**
     * Deletes a post.
     *
     * @param Post                   $post The post entity
     * @param EntityManagerInterface $em   The entity manager
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/posts/{id}/delete', name: 'post_delete', methods: ['POST'])]
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $this->postService->deletePost($post, $em);
        $this->addFlash('success', 'Post został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * Changes the category of a post.
     *
     * @param Request                $request The HTTP request
     * @param Post                   $post    The post entity
     * @param EntityManagerInterface $em      The entity manager
     *
     * @return Response
     */
    #[\Symfony\Component\Routing\Attribute\Route('/admin/post/{id}/change-category', name: 'post_change_category', methods: ['POST'])]
    public function changeCategory(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $categoryId = $request->request->getInt('category_id');
        $this->postService->changeCategory($post, $categoryId, $em);

        return $this->redirectToRoute('admin_dashboard');
    }
}

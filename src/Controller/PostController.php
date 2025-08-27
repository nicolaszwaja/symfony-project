<?php

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
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    public function __construct(private readonly PostServiceInterface $postService)
    {
    }

    #[\Symfony\Component\Routing\Attribute\Route('/posts', name: 'post_list')]
    public function list(Request $request): Response
    {
        $pagination = $this->postService->getPaginatedPosts($request, $request->query->getInt('page', 1));
        $categories = $this->postService->getCategories(); // dodaj metodę getCategories w serwisie
        $currentCategory = $request->query->get('category');

        return $this->render('post/list.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/posts/{id}', name: 'post_show')]
    public function show(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $post = $this->postService->getPostById($id);
        if (!$post instanceof \App\Entity\Post) {
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

    #[\Symfony\Component\Routing\Attribute\Route('/admin/posts/{id}/delete', name: 'post_delete', methods: ['POST'])]
    public function delete(Post $post, EntityManagerInterface $em): Response
    {
        $this->postService->deletePost($post, $em);
        $this->addFlash('success', 'Post został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }

    #[\Symfony\Component\Routing\Attribute\Route('/admin/post/{id}/change-category', name: 'post_change_category', methods: ['POST'])]
    public function changeCategory(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $categoryId = $request->request->getInt('category_id');
        $this->postService->changeCategory($post, $categoryId, $em);

        return $this->redirectToRoute('admin_dashboard');
    }
}

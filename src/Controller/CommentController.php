<?php

// src/Controller/CommentController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/{postId}/comments/add', name: 'comment_add', methods: ['POST'])]
public function add(Request $request, int $postId, EntityManagerInterface $em, PostRepository $postRepository): Response
{
    $post = $postRepository->find($postId);
    if (!$post) {
        throw $this->createNotFoundException('Post nie istnieje');
    }

    $comment = new Comment();
    $comment->setPost($post);
    $comment->setCreatedAt(new \DateTimeImmutable());

    $form = $this->createForm(CommentTypeForm::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('post_show', ['id' => $postId]);
    }

    // jeśli formularz jest na stronie posta, możesz renderować go z błędami
    return $this->render('post/show.html.twig', [
        'post' => $post,
        'form' => $form->createView(),
    ]);
}


    #[Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        // usuwanie komentarza (tylko admin)
        // na razie przekierowanie do listy postów lub tam gdzie chcesz
        return $this->redirectToRoute('post_index');
    }
}
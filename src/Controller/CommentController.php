<?php

// src/Controller/CommentController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/posts/{postId}/comments/add', name: 'comment_add', methods: ['POST'])]
    public function add(int $postId): Response
    {
        // tutaj dodasz logikę zapisu komentarza
        // na razie przekierujemy lub zwrócimy status
        return $this->redirectToRoute('post_show', ['id' => $postId]);
    }

    #[Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        // usuwanie komentarza (tylko admin)
        // na razie przekierowanie do listy postów lub tam gdzie chcesz
        return $this->redirectToRoute('post_index');
    }
}
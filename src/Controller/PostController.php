<?php
// src/Controller/PostController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts_list')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => [], // na razie pusta lista
        ]);
    }

}

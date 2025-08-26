<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentTypeForm;
use App\Service\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    public function __construct(private readonly CommentServiceInterface $commentService) {}

    #[Route('/posts/{postId}/comments/add', name: 'comment_add', methods: ['POST'])]
    public function add(Request $request, int $postId, EntityManagerInterface $em): Response
    {
        $post = $this->commentService->getPostById($postId);
        if (!$post) {
            throw $this->createNotFoundException('Post nie istnieje');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentTypeForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->addComment($comment, $em);
            return $this->redirectToRoute('post_show', ['id' => $postId]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $this->commentService->deleteComment($comment, $em);
        $this->addFlash('success', 'Komentarz został usunięty.');

        return $this->redirectToRoute('admin_dashboard');
    }
}
